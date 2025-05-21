<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Equipo; // Asegúrate de que este modelo existe y tiene las columnas necesarias
use Carbon\Carbon;

class SyncGlpiInventoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'glpi:sync-inventory'; // Cambié el nombre para claridad

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Sincroniza los datos de equipos desde GLPI API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando sincronización con GLPI API...');

        // Obtener credenciales desde .env
        $apiUrl = env('GLPI_API_URL');
        $appToken = env('GLPI_APP_TOKEN');
        $apiUser = env('GLPI_API_USER');
        $apiPassword = env('GLPI_API_PASSWORD');

        // Verificar que las configuraciones existan
        if (!$apiUrl || !$appToken || !$apiUser || !$apiPassword) {
            $this->error('Error: Faltan configuraciones de API de GLPI en el archivo .env');
            Log::error('Faltan configuraciones de API de GLPI.');
            return 1; // Indica error
        }

        $sessionToken = null; // Variable para almacenar el token de sesión

        try {
            // --- PASO 1: Iniciar Sesión (Obtener Session-Token) ---
            $this->info('Obteniendo Session-Token de la API de GLPI...');
            $sessionResponse = Http::withHeaders([
                'App-Token' => $appToken,
                'Content-Type' => 'application/json', // Importante indicar que enviamos JSON
            ])->post($apiUrl . '/initSession', [
                'login' => $apiUser,
                'password' => $apiPassword,
            ]);

            if (!$sessionResponse->successful()) {
                $this->error('Error al iniciar sesión en la API de GLPI: ' . $sessionResponse->status());
                $this->error('Respuesta del API: ' . $sessionResponse->body());
                Log::error('Error API initSession: ', [
                    'status' => $sessionResponse->status(),
                    'body' => $sessionResponse->body(),
                    'headers' => $sessionResponse->headers(),
                ]);
                return 1; // Indica error
            }

            $sessionData = $sessionResponse->json();
            $sessionToken = $sessionData['session_token'] ?? null;

            if (!$sessionToken) {
                 $this->error('Error: No se recibió session_token en la respuesta de inicio de sesión.');
                 Log::error('Respuesta initSession no contenía session_token.', ['body' => $sessionResponse->body()]);
                 return 1;
            }

            $this->info('Sesión iniciada correctamente. Session-Token obtenido.');

            // --- PASO 2: Obtener Datos de Equipos ---
            // Endpoint para obtener equipos
            $endpoint = '/Computer';
            $totalSynced = 0;
            $totalFailed = 0;
            $currentPage = 1;
            $perPage = 50; // Cantidad de elementos por página (ajusta si necesitas más o menos)

            $this->info("Obteniendo datos de equipos desde el endpoint: {$apiUrl}{$endpoint}");

            do {
                 $this->info("Solicitando página {$currentPage}...");

                 $computersResponse = Http::withHeaders([
                     'App-Token' => $appToken,
                     'Session-Token' => $sessionToken, // Usar el Session-Token obtenido
                     'Content-Type' => 'application/json',
                 ])->get($apiUrl . $endpoint, [
                     // Parámetros para obtener los datos que necesitamos
                     'expand_dropdowns' => true, // Para obtener nombres en lugar de IDs en campos relacionados
                     'get_hateoas' => false, // Para no obtener links HATEOAS (a menos que los necesites)
                     'is_deleted' => false, // Solo equipos no eliminados
                     // Parámetros de paginación para GLPI API v1
                     'page' => $currentPage,
                     'per_page' => $perPage,
                     'sort' => 'id', // Opcional: ordenar por ID
                     'order' => 'asc' // Opcional: orden ascendente
                 ]);

                 // Verificar si la solicitud a /Computer fue exitosa
                 if (!$computersResponse->successful()) {
                     $this->error('Error al obtener datos de equipos (página ' . $currentPage . '): ' . $computersResponse->status());
                     $this->error('Respuesta del API: ' . $computersResponse->body());
                     Log::error('Error API get Computers: ', [
                         'status' => $computersResponse->status(),
                         'body' => $computersResponse->body(),
                         'headers' => $computersResponse->headers(),
                     ]);
                     // Dependiendo del error, podrías intentar de nuevo o abortar
                     break; // Abortar en caso de error de solicitud
                 }

                 $computersData = $computersResponse->json();

                 // La respuesta JSON del endpoint /Computer es un array de objetos (equipos)
                 if (empty($computersData)) {
                     $this->info("No se encontraron más equipos (página {$currentPage} vacía).");
                     break; // Salir del bucle si la página está vacía (última página)
                 }

                 // --- Procesar y Guardar Datos ---
                 $this->info("Procesando " . count($computersData) . " equipos de la página {$currentPage}...");
                 foreach ($computersData as $computer) {
                     try {
                         // *** --- PASO CRÍTICO: MAPEADO DE DATOS --- ***
                         // Debes INSPECCIONAR EXACTAMENTE la respuesta JSON que te da el API de GLPI
                         // para el endpoint /Computer y ajustar estos nombres de campo.
                         // La estructura puede variar ligeramente dependiendo de la versión
                         // y los parámetros de 'expand_dropdowns'.

                         $datosEquipo = [
                             // ID interno de GLPI para este equipo
                             'glpi_id' => $computer['id'] ?? null,
                             // Nombre del equipo
                             'nombre' => $computer['name'] ?? null,
                             // Número de serial (clave única importante)
                             'serial' => $computer['serial'] ?? null,
                             // Información del Sistema Operativo (ejemplo asumiendo expand_dropdowns=true)
                             'sistema_operativo' => $computer['operatingsystems_id'] > 0 && isset($computer['operatingsystems_id_text']) ? $computer['operatingsystems_id_text'] : null, // Nombre SO
                             'version_so' => $computer['operatingsystemversions_id'] > 0 && isset($computer['operatingsystemversions_id_text']) ? $computer['operatingsystemversions_id_text'] : null, // Versión SO
                             'arquitectura_so' => $computer['operatingsystemarchitectures_id'] > 0 && isset($computer['operatingsystemarchitectures_id_text']) ? $computer['operatingsystemarchitectures_id_text'] : null, // Arquitectura SO
                             // Información de CPU - OJO: Esto es complejo, la API devuelve CPUs relacionadas
                             // Puede que necesites hacer una llamada adicional a /Computer/{id}/Item_Device?itemtype=Processor
                             // O buscar en el JSON expandido si hay un campo que resuma el procesador principal.
                             // Como ejemplo simple, intento obtener algo básico:
                             'cpu_tipo' => $computer['comment'] ?? null, // El campo 'comment' a veces contiene info resumida? VERIFICA TU API
                             'cpu_nucleos' => null, // No es un campo directo en Computer
                             // Información de RAM - OJO: La API devuelve Módulos de memoria relacionados
                             // Puede que necesites sumar las capacidades haciendo una llamada adicional a /Computer/{id}/Item_Device?itemtype=Memory
                             // O buscar un campo sumario si existe. Como ejemplo:
                             'ram_total_mb' => $computer['ram'] ?? null, // ¿Existe un campo 'ram' sumario? VERIFICA TU API
                             // Información de Red - OJO: La API devuelve Interfaces de red relacionadas
                             // Puede que necesites iterar sobre una relación o buscar campos directos si existen. Como ejemplo simple:
                             'ip_address' => $computer['have_last_mac'] ?? null, // ¿Es have_last_mac el IP principal? VERIFICA TU API O busca en relaciones.
                             'mac_address' => $computer['last_mac'] ?? null, // ¿Es last_mac el MAC principal? VERIFICA TU API O busca en relaciones.
                             // Usuario asignado (ejemplo asumiendo expand_dropdowns=true)
                              'usuario_actual' => $computer['users_id'] > 0 && isset($computer['users_id_text']) ? $computer['users_id_text'] : null, // Usuario asignado
                             // Fecha del último inventario (puede ser del agente o manual)
                             'ultimo_inventario_fi' => isset($computer['date_sync']) ? Carbon::parse($computer['date_sync']) : null, // Campo común es date_sync o date_mod

                             // Aquí puedes mapear otros campos que te interesen (fabricante, modelo, ubicación, etc.)
                             // 'fabricante' => $computer['manufacturers_id'] > 0 && isset($computer['manufacturers_id_text']) ? $computer['manufacturers_id_text'] : null,
                             // 'modelo' => $computer['computermodels_id'] > 0 && isset($computer['computermodels_id_text']) ? $computer['computermodels_id_text'] : null,
                             // 'ubicacion' => $computer['locations_id'] > 0 && isset($computer['locations_id_text']) ? $computer['locations_id_text'] : null,
                             // Si necesitas información detallada de procesadores, memoria, discos, etc.,
                             // tendrás que hacer llamadas adicionales a los endpoints específicos
                             // (ej: /api/v1/Computer/{id}/Item_Device?itemtype=Processor) o
                             // verificar si el endpoint /Computer soporta parámetros para incluirlos ('with_networkcards', 'with_disks', etc.)
                         ];

                         // *** --- FIN MAPEADO DE DATOS --- ***

                         // Validar si tenemos un identificador único fiable para updateOrCreate
                         // El 'serial' suele ser el mejor candidato para equipos físicos.
                         // Si el serial no es fiable, 'glpi_id' SIEMPRE es único, pero updateOrCreate por glpi_id
                         // significa que tendrías que asegurar que ese ID existe en tu DB local.
                         // Usar updateOrCreate por serial es común para inventarios.
                         // Asegúrate que tu tabla 'equipos' tiene una columna 'serial' (preferiblemente UNIQUE)
                         // y 'glpi_id' si decides usarlo también.

                         if (!empty($datosEquipo['serial'])) {
                              Equipo::updateOrCreate(
                                  ['serial' => $datosEquipo['serial']], // Condición de búsqueda (Serial)
                                  $datosEquipo // Valores a insertar o actualizar
                              );
                              $totalSynced++;
                         } else if (!empty($datosEquipo['glpi_id'])) {
                             // Alternativa: si no hay serial, usar el ID de GLPI como identificador local.
                             // Esto requiere que 'glpi_id' exista y sea único en tu tabla 'equipos'.
                              Equipo::updateOrCreate(
                                  ['glpi_id' => $datosEquipo['glpi_id']], // Condición de búsqueda (GLPI ID)
                                  $datosEquipo // Valores a insertar o actualizar
                              );
                              $totalSynced++;
                         }
                         else {
                             $this->warn("Equipo sin identificador único (ID GLPI: " . ($computer['id'] ?? 'N/A') . ", Nombre: " . ($computer['name'] ?? 'N/A') . ") - Omitido.");
                              Log::warning('Equipo omitido por falta de serial/GLPI ID', ['glpi_id' => $computer['id'] ?? null, 'name' => $computer['name'] ?? null]);
                              $totalFailed++;
                         }

                     } catch (\Exception $e) {
                         $equipoId = $computer['id'] ?? 'N/A';
                         $equipoNombre = $computer['name'] ?? 'N/A';
                         $this->error("Error procesando equipo GLPI ID {$equipoId} ('{$equipoNombre}'): " . $e->getMessage());
                         Log::error('Error procesando equipo GLPI ID: ' . $equipoId, ['exception' => $e, 'data' => $computer]);
                         $totalFailed++;
                     }
                 }

                 // Preparar para la siguiente página
                 $currentPage++;

                 // Determinar si hay más páginas para solicitar
                 // La API de GLPI v1 a veces indica el total en el header 'Content-Range'
                 // O simplemente verificamos si la cantidad de elementos recibidos es menor al límite por página.
                 // Si recibimos menos de $perPage, asumimos que es la última página.
                 if (count($computersData) < $perPage) {
                     break; // Asumimos que es la última página si no recibimos la cantidad completa
                 }

             } while (true); // El 'break' dentro del bucle controla la salida

        } finally {
            // --- PASO 3: Cerrar Sesión (Importante) ---
            // Asegurarnos de cerrar la sesión API aunque haya habido errores
            if ($sessionToken) {
                $this->info('Cerrando sesión de la API de GLPI...');
                try {
                     $logoutResponse = Http::withHeaders([
                         'App-Token' => $appToken,
                         'Session-Token' => $sessionToken,
                     ])->get($apiUrl . '/killSession'); // O POST, verifica doc API si es GET o POST

                     if (!$logoutResponse->successful()) {
                          $this->warn('Advertencia: No se pudo cerrar la sesión de la API.');
                          Log::warning('Error API killSession: ', ['status' => $logoutResponse->status(), 'body' => $logoutResponse->body()]);
                     } else {
                          $this->info('Sesión cerrada correctamente.');
                     }
                } catch (\Exception $e) {
                     $this->warn('Advertencia: Excepción al intentar cerrar la sesión de la API.');
                     Log::warning('Excepción al cerrar sesión API: ', ['exception' => $e]);
                }
            }
        }

        $this->info("Sincronización completada. Equipos procesados: {$totalSynced}, Errores/Omitidos: {$totalFailed}");
        return 0; // Indica éxito
    }

    // Puedes añadir funciones helper aquí si necesitas lógica compleja para mapear campos
    // Por ejemplo, una función para obtener detalles de un equipo específico si el /Computer general
    // no trae toda la información necesaria en el primer nivel.
}
