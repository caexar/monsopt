<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('empresa')->nullable();
            $table->string('id_pc')->nullable();
            $table->string('tipo_soporte')->nullable();
            $table->string(('nombre_solicitante'))->nullable();
            $table->string('email_solicitante')->nullable();
            $table->string('telefono_solicitante')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha_solicitud_inicio')->nullable();
            $table->date('fecha_solicitud_fin')->nullable();
            $table->boolean('estado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
