<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Equipo;

class ImportarEquipos extends Command
{
    // Ruta por defecto al archivo JSON
    protected $signature = 'importar:equipos {ruta=C:\temp\inventario_utf8.json}';
    protected $description = 'Importa datos de equipos desde un archivo JSON a la base de datos';

    public function handle()
    {
        $ruta = $this->argument('ruta');

        if (!File::exists($ruta)) {
            $this->error(" El archivo no existe: $ruta");
            return 1;
        }

        $contenido = File::get($ruta);
        $datos = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error(" El archivo JSON no es válido: " . json_last_error_msg());
            return 1;
        }

        $contador = 0;

        foreach ($datos as $item) {
            // Puedes agregar validación si quieres evitar errores por campos faltantes
            Equipo::create([
                'hostname'     => $item['hostname'] ?? null,
                'uuid'         => $item['uuid'] ?? null,
                'manufacturer' => $item['manufacturer'] ?? null,
                'product_name' => $item['product_name'] ?? null,
                'os'           => $item['os'] ?? null,
                'arch'         => $item['arch'] ?? null,
                'cpu'          => $item['cpu'] ?? null,
                'memory'       => $item['memory'] ?? null,
            ]);
            $contador++;
        }

        $this->info(" Importación completada: $contador equipos cargados desde $ruta");
        return 0;
    }
}
