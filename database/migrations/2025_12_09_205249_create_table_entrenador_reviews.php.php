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
        Schema::create('entrenador_reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('trainer_id');
        $table->tinyInteger('rating'); // 1 a 5
        $table->text('comentario')->nullable();
        $table->timestamps();

        // FOREIGN KEYS
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
