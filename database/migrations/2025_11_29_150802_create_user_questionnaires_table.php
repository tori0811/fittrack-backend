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
        Schema::create('user_questionnaires', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            // Datos del cuestionario
            $table->string('objetivo')->nullable();
            $table->string('actividad')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('altura', 5, 2)->nullable();
            $table->integer('dias')->nullable();
            $table->string('experiencia')->nullable();

            // Lesiones
            $table->string('tuvo_lesion')->nullable();
            $table->text('lesion_pasada')->nullable();

            // Dieta
            $table->json('intolerancias')->nullable();
            $table->string('estilo_alimentacion')->nullable();
            $table->text('alimentos_no_gustan')->nullable();

            //Habitos
            $table->string('agua')->nullable();
            $table->string('sueno')->nullable();
            $table->string('estres')->nullable();


            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_questionnaires');
    }
};
