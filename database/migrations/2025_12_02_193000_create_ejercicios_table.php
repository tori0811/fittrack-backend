<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('entreno_id');

            $table->string('grupo_muscular');   // Pecho, Espalda, Pierna...
            $table->string('nombre');           // Press banca, Sentadilla...
            $table->string('video_url')->nullable();
            $table->integer('fatiga')->nullable(); // 1–10 (opcional)

            $table->timestamps();

            $table->foreign('entreno_id')
                  ->references('id')
                  ->on('entrenos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};
