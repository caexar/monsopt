<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->string('hostname')->nullable();
        $table->string('uuid')->nullable();
        $table->string('manufacturer')->nullable();
        $table->string('product_name')->nullable();
        $table->string('os')->nullable();
        $table->string('arch')->nullable();
        $table->string('cpu')->nullable();
        $table->string('memory')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
