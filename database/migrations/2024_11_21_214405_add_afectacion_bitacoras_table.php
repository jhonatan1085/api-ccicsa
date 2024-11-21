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
            $table->boolean('afect_servicio')->default(false)->after("tiempo_solucion");
            $table->boolean('afect_masiva')->default(false)->after("afect_servicio");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->dropColumn('afect_servicio');
            $table->dropColumn('afect_masiva');

        });
    }
};
