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
        Schema::create('bitacora_brigada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brigada_id');
            $table->foreign('brigada_id')->references('id')->on('brigadas');
            $table->unsignedBigInteger('bitacora_id');
            $table->foreign('bitacora_id')->references('id')->on('bitacoras');
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
        Schema::dropIfExists('bitacora_brigada');
    }
};
