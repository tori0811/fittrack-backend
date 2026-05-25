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
    Schema::create('dietas', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');     // cliente
        $table->unsignedBigInteger('trainer_id');  // entrenador

        $table->string('titulo');

        // Información calórica
        $table->integer('calorias_on')->nullable();
        $table->integer('calorias_off')->nullable();

        // Macros día ON
        $table->integer('proteinas_on')->nullable();
        $table->integer('carbohidratos_on')->nullable();
        $table->integer('grasas_on')->nullable();

        // Macros día OFF
        $table->integer('proteinas_off')->nullable();
        $table->integer('carbohidratos_off')->nullable();
        $table->integer('grasas_off')->nullable();

        // Actividad recomendada
        $table->string('actividad_on')->nullable();
        $table->string('actividad_off')->nullable();

        // Instrucciones adicionales
        $table->text('pre_entreno')->nullable();
        $table->text('intra_entreno')->nullable();

        $table->boolean('activa')->default(true);

        $table->timestamps();

        // Relaciones con users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('dietas');
}

};
