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
    Schema::create('series_ejercicio', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('ejercicio_id');

        // Objetivos del entrenador
        $table->string('reps_objetivo')->nullable(); 
        $table->string('rpe_objetivo')->nullable();  

        // Datos reales del cliente
        $table->string('peso')->nullable();          
        $table->string('reps')->nullable();          
        $table->string('rpe')->nullable();           
        $table->timestamps();

        $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('series_ejercicio');
}

};
