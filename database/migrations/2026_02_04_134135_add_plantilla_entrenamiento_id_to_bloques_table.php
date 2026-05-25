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
        Schema::table('bloques', function (Blueprint $table) {
            $table->unsignedBigInteger('plantilla_entrenamiento_id')->nullable()->after('trainer_id');

            $table->foreign('plantilla_entrenamiento_id')
                ->references('id')
                ->on('plantillas_entrenamiento')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bloques', function (Blueprint $table) {
            $table->dropForeign(['plantilla_entrenamiento_id']);
            $table->dropColumn('plantilla_entrenamiento_id');
        });
    }
};
