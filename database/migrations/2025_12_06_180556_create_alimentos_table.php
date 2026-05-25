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
    Schema::create('alimentos', function (Blueprint $table) {
        $table->id();

        $table->string('nombre');                // Ej: "Arroz blanco cocido"
        $table->string('categoria');
        $table->float('proteinas');              // g por 100g
        $table->float('carbohidratos');          // g por 100g
        $table->float('grasas');                 // g por 100g
        $table->integer('kcal_por_100g');        // kcal por 100g

        $table->timestamps();
    });
}

};
