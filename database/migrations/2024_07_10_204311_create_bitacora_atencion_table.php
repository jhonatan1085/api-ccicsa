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
        Schema::create('bitacora_atencion', function (Blueprint $table) {
            $table->id();
            $table->char('hora',5); 
            $table->string('descripcion',250);
            $table->integer('orden');
            $table->unsignedBigInteger('bitacora_id');
            $table->foreign('bitacora_id')->references('id')->on('bitacoras');
            $table->unsignedBigInteger('atencion_id');
            $table->foreign('atencion_id')->references('id')->on('atencions');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('bitacora_atencion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_atencion');
    }
};
