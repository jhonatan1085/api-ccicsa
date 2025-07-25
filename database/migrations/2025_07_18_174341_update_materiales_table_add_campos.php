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
        Schema::table('materiales', function (Blueprint $table) {
            // Renombrar columna
            $table->renameColumn('referencia', 'codigoSAP');
            // Llave foránea (opcional si existe tabla subcategorias)
            
            // Nuevas columnas
            $table->string('codigoAX', 25)->nullable()->after('descripcion');

            if (!Schema::hasColumn('materiales', 'sub_categoria_id')) {
                $table->foreignId('sub_categoria_id')->nullable()->after('codigoAX')->constrained('sub_categorias');
            }
            $table->decimal('precio', 10, 2)->nullable()->after('sub_categoria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            // Volver atrás los cambios
            $table->renameColumn('codigoSAP', 'referencia');
            $table->dropForeign(['sub_categoria_id']);
            $table->dropColumn(['sub_categoria_id', 'codigoAX', 'precio']);
        });
    }
};
