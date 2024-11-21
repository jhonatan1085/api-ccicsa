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
        Schema::table('causa_averias', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_causa_averia_id')->nullable()->after('nombre');
            $table->foreign('tipo_causa_averia_id')->references('id')->on('tipo_causa_averias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('causa_averias', function (Blueprint $table) {
            $table->dropColumn('tipo_causa_averia_id');
        });
    }
};
