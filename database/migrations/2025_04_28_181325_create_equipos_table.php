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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id(); // ID interno de Laravel
            $table->string('empresa')->nullable(); // Nombre del equipo (hostname)
            $table->unsignedBigInteger('fusion_inventory_id')->unique()->nullable(); // ID del equipo en FusionInventory/GLPI
            $table->string('nombre')->nullable();
            $table->string('serial')->unique()->nullable(); // ¡Importante usar un identificador único de FI!
            $table->string('sistema_operativo')->nullable();
            $table->string('version_so')->nullable();
            $table->string('arquitectura_so')->nullable();
            $table->string('cpu_tipo')->nullable();
            $table->integer('cpu_nucleos')->nullable();
            $table->integer('ram_total_mb')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('usuario_actual')->nullable();
            $table->timestamp('ultimo_inventario_fi')->nullable(); // Fecha del último inventario en FI
            $table->text('otros_datos_json')->nullable(); // Para guardar datos extra como JSON
            $table->timestamps(); // created_at, updated_at (en tu DB Laravel)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
