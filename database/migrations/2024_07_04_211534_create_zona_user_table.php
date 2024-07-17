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
        Schema::create('zona_user', function (Blueprint $table) {
            $table->id();
            $table->char('is_user',1)->default('1'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->unsignedBigInteger('tipo_planta_id');
            $table->foreign('tipo_planta_id')->references('id')->on('tipo_plantas');
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->char('estado',1)->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_user');
    }
};
