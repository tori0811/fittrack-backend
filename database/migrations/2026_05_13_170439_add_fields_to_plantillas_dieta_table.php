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
    Schema::table('plantillas_dieta', function (Blueprint $table) {
        $table->string('tipo')->nullable()->after('titulo');
        $table->string('tema')->nullable()->after('tipo');
        $table->text('descripcion')->nullable()->after('tema');
        $table->boolean('modo_seguro')->default(false)->after('descripcion');
        $table->json('alergenos')->nullable()->after('modo_seguro');
        $table->json('advertencias')->nullable()->after('alergenos');
    });
}

public function down(): void
{
    Schema::table('plantillas_dieta', function (Blueprint $table) {
        $table->dropColumn(['tipo', 'tema', 'descripcion', 'modo_seguro', 'alergenos', 'advertencias']);
    });
}
};
