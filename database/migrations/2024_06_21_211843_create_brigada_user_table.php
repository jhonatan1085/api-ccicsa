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
        Schema::create('brigada_user', function (Blueprint $table) {
            $table->id();
            $table->char('is_lider',1)->default('0'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('brigada_id');
            $table->foreign('brigada_id')->references('id')->on('brigadas');
            $table->unsignedBigInteger('unidad_movil_id')->nullable();
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
        Schema::dropIfExists('brigada_user');
    }
};
