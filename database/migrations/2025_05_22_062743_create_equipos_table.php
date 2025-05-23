<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->number('referencia')->nullable();
            $table->string('tipo')->nullable();
            $table->string('nombre');
            $table->text('detalles')->nullable();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('velocidad')->nullable();
            $table->string('margen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
}
