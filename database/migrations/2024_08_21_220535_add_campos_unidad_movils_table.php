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
        Schema::table('unidad_movils', function (Blueprint $table) {
            $table->decimal('kilometraje', 6, 2)->nullable()->after('placa');
            $table->unsignedBigInteger('modelo_id')->nullable()->after('kilometraje');
            $table->foreign('modelo_id')->references('id')->on('modelos');
            $table->unsignedBigInteger('color_id')->nullable()->after('modelo_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->char('estado',1)->default('1')->after('color_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidad_movils', function (Blueprint $table) {
            $table->dropColumn('kilometraje');
            $table->dropColumn('modelo_id');
            $table->dropColumn('color_id');
            $table->dropColumn('estado');
        });
    }
};
