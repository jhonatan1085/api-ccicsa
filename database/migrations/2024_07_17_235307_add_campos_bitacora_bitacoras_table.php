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
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->unsignedBigInteger('causa_averia_id')->nullable()->after('estado');
            $table->foreign('causa_averia_id')->references('id')->on('causa_averias');
            $table->unsignedBigInteger('consecuencia_averia_id')->nullable()->after('causa_averia_id');
            $table->foreign('consecuencia_averia_id')->references('id')->on('consecuencia_averias');
            $table->unsignedBigInteger('tipo_reparacion_id')->nullable()->after('consecuencia_averia_id');
            $table->foreign('tipo_reparacion_id')->references('id')->on('tipo_reparacions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->dropColumn('causa_averia_id');
            $table->dropColumn('consecuencia_averia_id');
            $table->dropColumn('tipo_reparacion_id');
        });
    }
};
