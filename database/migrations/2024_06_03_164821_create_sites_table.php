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
            $table->string('direccion',200)->nullable();
            $table->unsignedBigInteger('municipalidade_id');
            $table->foreign('municipalidade_id')->references('id')->on('municipalidades');
            $table->unsignedBigInteger('distrito_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');
            $table->unsignedBigInteger('tipo_site_id');
            $table->foreign('tipo_site_id')->references('id')->on('tipo_sites');
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->unsignedBigInteger('region_geografica_id');
            $table->foreign('region_geografica_id')->references('id')->on('region_geograficas');
            $table->string('tiempo_sla',25)->nullable();
            $table->string('autonomia_bts',25)->nullable();
            $table->string('autonomia_tx',25)->nullable();
            $table->string('tiempo_auto',25)->nullable();
            $table->string('tiempo_caminata',25)->nullable();
            $table->string('tiempo_acceso',25)->nullable();
            $table->string('suministro',20)->nullable();
            $table->unsignedBigInteger('consesionaria_id');
            $table->foreign('consesionaria_id')->references('id')->on('consesionarias');
            $table->unsignedBigInteger('room_type_id');
            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->unsignedBigInteger('contratista_id');
            $table->foreign('contratista_id')->references('id')->on('contratistas');
            $table->unsignedBigInteger('tipo_acceso_id');
            $table->foreign('tipo_acceso_id')->references('id')->on('tipo_accesos');
            $table->unsignedBigInteger('prioridad_site_id');
            $table->foreign('prioridad_site_id')->references('id')->on('prioridad_sites');
            $table->unsignedBigInteger('tipo_energia_id');
            $table->foreign('tipo_energia_id')->references('id')->on('tipo_energias');
            $table->string('observacion')->nullable();
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
