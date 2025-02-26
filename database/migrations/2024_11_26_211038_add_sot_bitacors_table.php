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
            $table->timestamp('fecha_sot')->nullable('NULL')->after("sot");
            $table->boolean('estado_sot')->default(true)->after("fecha_sot");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->dropColumn('fecha_sot');
            $table->dropColumn('estado_sot');
        });
    }
};
