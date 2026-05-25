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
    Schema::create('opciones_comida', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('comida_id');

        $table->string('titulo_opcion')->nullable(); // "Opción 1", "Opción alta proteína"
        $table->json('alimentos'); // lista de alimentos en formato JSON

        $table->timestamps();

        $table->foreign('comida_id')->references('id')->on('comidas')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('opciones_comida');
}
};
