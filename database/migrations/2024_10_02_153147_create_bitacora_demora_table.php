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
        Schema::create('bitacora_demora', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('bitacora_id');
            $table->foreign('bitacora_id')->references('id')->on('bitacoras');
            $table->unsignedBigInteger('tipo_demora_id');
            $table->foreign('tipo_demora_id')->references('id')->on('tipo_demoras');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('orden');
            $table->unsignedBigInteger('user_created_by')->nullable();
            $table->foreign('user_created_by')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated_by')->nullable();
            $table->foreign('user_updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_demora');
    }
};
