<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventarioController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Headers recibidos:', $request->headers->all());
        $rawContent = $request->getContent(); // Obtener el contenido RAW
        Log::info('Contenido RAW del request:', [$rawContent]);

        // Intentar decodificar el contenido RAW como JSON, ignorando el Content-Type
        $data = json_decode($rawContent, true); // true para array asociativo

        // Si la decodificación falla, $data será null
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('El contenido RAW no es JSON válido o hubo un error al decodificar.');
            Log::error('Error de JSON decode:', [json_last_error_msg()]);
            $data = []; // Asegurarse de que $data sea un array para la siguiente verificación
        }

        Log::info('Contenido de $data procesado:', $data);

        if (!empty($data)) {
            Log::info('Datos recibidos y procesados correctamente. Listos para guardar.');
            // Aquí iría tu lógica para guardar en la base de datos
            return response()->json(['message' => 'Inventario recibido correctamente', 'data_partial' => array_slice($data, 0, 2)], 200);
        } else {
            Log::error('No se recibieron datos o no pudieron ser procesados.');
            return response()->json(['message' => 'No se recibieron datos o el formato no es correcto'], 400);
        }
    }
}
