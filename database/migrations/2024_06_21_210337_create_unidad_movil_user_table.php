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
        Schema::create('unidad_movil_user', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->integer('km_inicial');
            $table->integer('km_final')->nullable();
            $table->char('estado',1)->default('1');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('unidad_movil_id');
            $table->foreign('unidad_movil_id')->references('id')->on('unidad_movils');
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
        Schema::dropIfExists('unidad_movil_user');
    }
};
