<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'hostname',
        'uuid',
        'manufacturer',
        'product_name',
        'os',
        'arch',
        'cpu',
        'memory',
    ];

}
