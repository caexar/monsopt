<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->getContent();
        $hostname = 'local';

        Inventario::create([
            'hostname' => $hostname,
            'data' => $data,
        ]);

        // Convertimos el contenido de texto a un array
        $decodedData = json_decode($data, true);

        if (isset($decodedData['content'])) {
            $content = $decodedData['content'];

            // Procesar y guardar CPUs
            if (isset($content['cpus']) && is_array($content['cpus'])) {
                foreach ($content['cpus'] as $cpu) {
                    DB::table('equipos')->insert([
                        'nombre' => $cpu['name'] ?? '',
                        'detalles' => $cpu['description'] ?? '',
                        'modelo' => $cpu['model'] ?? '',
                        'referencia' => $cpu['id'] ?? '',
                        'marca' => $cpu['manufacturer'] ?? '',
                        'velocidad' => $cpu['speed'] ?? 0,
                        'tipo' => 'CPU',
                        'margen' => $cpu['core'] ?? 0,
                    ]);
                }
            }

            // Procesar memorias
            if (isset($content['memories']) && is_array($content['memories'])) {
                foreach ($content['memories'] as $memory) {
                    DB::table('equipos')->insert([
                        'nombre' => $memory['caption'] ?? '',
                        'detalles' => $memory['description'] ?? '',
                        'modelo' => $memory['model'] ?? '',
                        'referencia' => $memory['serialnumber'] ?? '',
                        'marca' => $memory['manufacturer'] ?? '',
                        'velocidad' => $memory['speed'] ?? 0,
                        'tipo' => $memory['type'] ?? '',
                        'margen' => $memory['capacity'] ?? 0,
                    ]);
                }
            }

            // Procesar almacenamiento
            if (isset($content['storages']) && is_array($content['storages'])) {
                foreach ($content['storages'] as $storage) {
                    DB::table('equipos')->insert([
                        'nombre' => $storage['name'] ?? '',
                        'detalles' => $storage['description'] ?? '',
                        'modelo' => $storage['model'] ?? '',
                        'referencia' => $storage['serial'] ?? '',
                        'marca' => $storage['interface'] ?? '',
                        'velocidad' => $storage['disksize'] ?? 0,
                        'tipo' => $storage['type'] ?? '',
                        'margen' => 0, 
                    ]);
                }
            }

            // Procesar puertos
            if (isset($content['ports']) && is_array($content['ports'])) {
                foreach ($content['ports'] as $port) {
                    DB::table('equipos')->insert([
                        'nombre' => $port['name'] ?? '',
                        'detalles' => $port['description'] ?? '',
                        'modelo' => '',
                        'referencia' => '',
                        'marca' => '',
                        'velocidad' => 0,
                        'tipo' => $port['type'] ?? '',
                        'margen' => 0,
                    ]);
                }
            }

            // Procesar videos
            if (isset($content['videos']) && is_array($content['videos'])) {
                foreach ($content['videos'] as $video) {
                    DB::table('equipos')->insert([
                        'nombre' => $video['name'] ?? '',
                        'detalles' => $video['chipset'] ?? '',
                        'modelo' => '',
                        'referencia' => '',
                        'marca' => '',
                        'velocidad' => $video['memory'] ?? 0,
                        'tipo' => 'Video',
                        'margen' => 0,
                    ]);
                }
            }

            // Procesar redes
            if (isset($content['networks']) && is_array($content['networks'])) {
                foreach ($content['networks'] as $network) {
                    DB::table('equipos')->insert([
                        'nombre' => $network['description'] ?? '',
                        'detalles' => '',
                        'modelo' => '',
                        'referencia' => $network['mac'] ?? '',
                        'marca' => '',
                        'velocidad' => $network['speed'] ?? 0,
                        'tipo' => $network['type'] ?? '',
                        'margen' => 0,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
