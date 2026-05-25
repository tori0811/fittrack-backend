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
        Schema::create('plantillas_dieta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('titulo');
            $table->integer('calorias_on')->nullable();
            $table->integer('calorias_off')->nullable();
            $table->integer('proteinas_on')->nullable();
            $table->integer('proteinas_off')->nullable();
            $table->integer('carbohidratos_on')->nullable();
            $table->integer('carbohidratos_off')->nullable();
            $table->integer('grasas_on')->nullable();
            $table->integer('grasas_off')->nullable();
            $table->string('actividad_on')->nullable();
            $table->string('actividad_off')->nullable();
            $table->string('pre_entreno')->nullable();
            $table->string('post_entreno')->nullable();
            $table->tinyInteger('activa')->default(0);

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantillas_dieta');
    }
};
