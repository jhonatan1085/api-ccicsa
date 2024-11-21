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
        Schema::create('brigadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->unsignedBigInteger('tipo_brigada_id');
            $table->foreign('tipo_brigada_id')->references('id')->on('tipo_brigadas');
            $table->unsignedBigInteger('contratista_id');
            $table->foreign('contratista_id')->references('id')->on('contratistas');
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->char('estado',1)->default('1');
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
        Schema::dropIfExists('brigadas');
    }
};
