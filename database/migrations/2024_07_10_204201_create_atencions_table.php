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
        Schema::create('atencions', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',80);
            $table->integer('orden');
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
        Schema::dropIfExists('atencions');
    }
};
