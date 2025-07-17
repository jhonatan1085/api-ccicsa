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
        Schema::create('bitacora_brigada_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bitacora_brigada_id')->constrained('bitacora_brigada')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('unidad_movil_id')->nullable()->constrained('unidad_movils')->onDelete('set null');
             $table->boolean('is_lider')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_brigada_user');
    }
};
