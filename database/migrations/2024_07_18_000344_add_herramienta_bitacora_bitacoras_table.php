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
            $table->text('herramientas')->nullable()->after('tipo_reparacion_id');
            $table->string('tiempo_solucion',50)->nullable()->after('herramientas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
            $table->dropColumn('herramientas');
            $table->dropColumn('tiempo_solucion');
        });
    }
};
