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
        Schema::table('brigada_user', function (Blueprint $table) {
            $table->boolean('estado')->default(true)->after('unidad_movil_id'); // true: activo
            $table->dateTime('fecha_alta')->nullable()->after('estado');
            $table->dateTime('fecha_baja')->nullable()->after('fecha_alta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brigada_user', function (Blueprint $table) {
             $table->dropColumn(['estado', 'fecha_alta', 'fecha_baja']);
        });
    }
};
