<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // Para evitar MassAssignmentException. Lista los campos que SÍ quieres poder asignar masivamente.
    protected $fillable = [
        'fusion_inventory_id',
        'empresa',
        'nombre',
        'serial',
        'sistema_operativo',
        'version_so',
        'arquitectura_so',
        'cpu_tipo',
        'cpu_nucleos',
        'ram_total_mb',
        'ip_address',
        'mac_address',
        'usuario_actual',
        'ultimo_inventario_fi',
        'otros_datos_json',
    ];

    protected $casts = [
        'ultimo_inventario_fi' => 'datetime',
        'otros_datos_json' => 'array',
        'ram_total_mb' => 'integer',
        'cpu_nucleos' => 'integer',
    ];
}
