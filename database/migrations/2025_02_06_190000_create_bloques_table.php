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
    Schema::create('bloques', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('trainer_id');

        $table->string('titulo');                // Ej: "Hipertrofia Fase 1"
        $table->text('descripcion')->nullable();

        $table->integer('numero_microciclos');   // Ej: 8
        $table->boolean('completado')->default(false);

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
