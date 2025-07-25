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
            $table->unsignedBigInteger('site_fin_id')->nullable()->after('site_id');
            $table->foreign('site_fin_id')->references('id')->on('sites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('bitacoras', function (Blueprint $table) {
            $table->dropForeign(['site_fin_id']);
            $table->dropColumn('site_fin_id');
        });
    }
};
