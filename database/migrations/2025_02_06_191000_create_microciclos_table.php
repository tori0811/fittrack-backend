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
    Schema::create('microciclos', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('bloque_id');

        $table->integer('numero');               // Microciclo 1,2,3...
        $table->boolean('descarga')->default(false); // El microciclo de descarga(menos carga,menos volumen y menos series) final del bloque
        $table->boolean('completado')->default(false);

        $table->timestamps();

        $table->foreign('bloque_id')->references('id')->on('bloques')->onDelete('cascade');
    });
}

};
