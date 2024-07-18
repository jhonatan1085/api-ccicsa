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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',250);
            $table->timestamp('fecha_inicial')->nullable('NULL');
            $table->string('sot',45)->nullable('NULL');
            $table->string('insidencia',45)->nullable('NULL');
            $table->unsignedBigInteger('tipo_averia_id');
            $table->foreign('tipo_averia_id')->references('id')->on('tipo_averias');
            $table->string('latitud',25)->nullable('NULL');
            $table->string('longitud',25)->nullable('NULL');
            $table->integer('distancia')->nullable('NULL');
            $table->unsignedBigInteger('red_id');
            $table->foreign('red_id')->references('id')->on('reds');
            $table->unsignedBigInteger('serv_id');
            $table->foreign('serv_id')->references('id')->on('servs');
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites');
            $table->unsignedBigInteger('resp_cicsa_id');
            $table->foreign('resp_cicsa_id')->references('id')->on('users');
            $table->unsignedBigInteger('resp_claro_id');
            $table->foreign('resp_claro_id')->references('id')->on('users');
            $table->char('estado',1)->default('1'); 
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
