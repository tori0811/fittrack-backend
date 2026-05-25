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
    Schema::create('comidas', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('dieta_id');

        $table->string('tipo'); // desayuno, comida1, comida2, cena...
        $table->enum('dia', ['on', 'off']); //día entreno o descanso
        $table->time('hora')->nullable();

        $table->timestamps();

        $table->foreign('dieta_id')->references('id')->on('dietas')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('comidas');
}

};
