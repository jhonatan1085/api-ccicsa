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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',20);
            $table->string('nombre',45);
            $table->string('latitud',25)->nullable();
            $table->string('longitud',25)->nullable();
            $table->unsignedBigInteger('municipalidade_id');
            $table->foreign('municipalidade_id')->references('id')->on('municipalidades');
            $table->string('direccion',200)->nullable();
            $table->unsignedBigInteger('tipo_site_id');
            $table->foreign('tipo_site_id')->references('id')->on('tipo_sites');
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->unsignedBigInteger('region_geografica_id');
            $table->foreign('region_geografica_id')->references('id')->on('region_geograficas');
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('sites');
    }
};
