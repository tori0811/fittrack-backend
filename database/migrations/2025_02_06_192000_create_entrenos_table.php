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
    Schema::create('entrenos', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('microciclo_id');

        $table->string('titulo');                // Día 1 - Pecho y tríceps
        $table->string('dia_semana');
        $table->integer('orden');                // posición dentro del microciclo
        $table->boolean('completado')->default(false);

        $table->timestamps();

        $table->foreign('microciclo_id')->references('id')->on('microciclos')->onDelete('cascade');
    });
}

};
