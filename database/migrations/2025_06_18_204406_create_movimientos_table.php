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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
             // Relaciones principales
            $table->foreignId('brigada_id')->constrained('brigadas')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materiales')->onDelete('cascade');
            // Detalle del movimiento
            $table->enum('tipo', ['ingreso', 'salida', 'ajuste']);
            $table->decimal('cantidad', 10, 2);
            $table->timestamp('fecha_movimiento');
            $table->text('motivo')->nullable();

            // Relación opcional con usuario y bitácora
            $table->foreignId('bitacora_id')->nullable()->constrained('bitacoras')->onDelete('set null');
            // Identificador de traspaso (para unir entrada y salida)
            $table->uuid('traslado_uuid')->nullable();

            //usuario
            $table->unsignedBigInteger('user_created_by')->nullable();
            $table->foreign('user_created_by')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated_by')->nullable();
            $table->foreign('user_updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
