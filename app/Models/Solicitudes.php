<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        'empresa',
        'id_pc',
        'tipo_soporte',
        'nombre_solicitante',
        'email_solicitante',
        'telefono_solicitante',
        'descripcion',
        'fecha_solicitud_inicio',
        'fecha_solicitud_fin',
        'estado',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
