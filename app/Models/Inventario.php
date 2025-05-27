<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = [
        'id',
        'empresa',
        'tipo_pc',
        'referencia',
        'hostname',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
