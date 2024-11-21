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
        Schema::table('municipalidades', function (Blueprint $table) {
            $table->unsignedBigInteger('distrito_id')->nullable()->after('nombre');
            $table->foreign('distrito_id')->references('id')->on('distritos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('municipalidades', function (Blueprint $table) {
            $table->dropColumn('distrito_id');
        });
    }
};
