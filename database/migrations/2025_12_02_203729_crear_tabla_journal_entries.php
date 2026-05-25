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
    Schema::create('journal_entries', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id'); // cliente

        $table->date('fecha'); 
        $table->string('estado_animo')->nullable(); // feliz, cansado, motivado...
        $table->integer('energia')->nullable();     // 1-5
        $table->integer('suenio_horas')->nullable();
        $table->boolean('entreno')->default(false);
        $table->text('nota')->nullable();

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('journal_entries');
}

};
