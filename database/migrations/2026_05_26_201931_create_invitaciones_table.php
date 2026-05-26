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
    Schema::create('invitaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('entrenador_id')->constrained('users')->onDelete('cascade');
        $table->string('email');
        $table->string('token')->unique();
        $table->boolean('usado')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitaciones');
    }
};
