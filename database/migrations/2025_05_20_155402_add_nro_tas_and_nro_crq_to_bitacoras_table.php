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
            $table->string('nro_tas',25)->nullable()->after('serv_id');
            $table->string('nro_crq',25)->nullable()->after('nro_tas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bitacoras', function (Blueprint $table) {
             $table->dropColumn('nro_tas');
            $table->dropColumn('nro_crq');
        });
    }
};
