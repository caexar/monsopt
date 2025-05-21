<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = [
        'hostname',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
