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
    Schema::create('progreso_medidas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');

        $table->date('fecha');

        // Medidas corporales 
        $table->decimal('pecho', 5, 2)->nullable();
        $table->decimal('espalda', 5, 2)->nullable();
        $table->decimal('cintura', 5, 2)->nullable();
        $table->decimal('cadera', 5, 2)->nullable();
        $table->decimal('brazo', 5, 2)->nullable();
        $table->decimal('pierna', 5, 2)->nullable();
        $table->decimal('gemelo', 5, 2)->nullable();

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('progreso_medidas');
}

};
