<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;

class InventarioController extends Controller
{
    public function store(Request $request)
{
    $data = $request->json()->all();
    $item = [];

    // Verificar y limpiar datos
    array_walk_recursive($data, function (&$item) {
        if (!mb_check_encoding($item, 'UTF-8')) {
            $item = utf8_encode($item); // Codificar a UTF-8 si es necesario
        }
    });

    $hostname = $item['deviceid']?? 'sin_nombre';

    Inventario::create([
        'hostname' => $hostname,
        'data' => $item,
    ]);

    return response()->json(['status' => 'ok']);
}
}
