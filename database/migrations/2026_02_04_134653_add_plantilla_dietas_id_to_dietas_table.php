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
        Schema::table('dietas', function (Blueprint $table) {
            $table->unsignedBigInteger('plantillas_dieta_id')->nullable()->after('trainer_id');

            $table->foreign('plantillas_dieta_id')
                ->references('id')
                ->on('plantillas_dieta')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dietas', function (Blueprint $table) {
            $table->dropForeign(['plantillas_dieta_id']);
            $table->dropColumn('plantillas_dieta_id');
        });
    }
};
