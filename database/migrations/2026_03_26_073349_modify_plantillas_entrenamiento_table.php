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
        Schema::table('plantillas_entrenamiento', function (Blueprint $table) {
        $table->renameColumn('objetivo', 'type');
        $table->string('gender');
        $table->string('routineType');
        $table->string('level');
        $table->string('theme');
        $table->renameColumn('nombre', 'name');
        $table->renameColumn('descripcion' , 'description');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantillas_entrenamiento', function (Blueprint $table) {
            $table->renameColumn('type', 'objetivo');
            $table->dropColumn('gender');
            $table->dropColumn('routineType');
            $table->dropColumn('level');
            $table->dropColumn('theme');
            $table->renameColumn('name', 'nombre');
            $table->renameColumn('description', 'descripcion');
            
        });
    }
};
