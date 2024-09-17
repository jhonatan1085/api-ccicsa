<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMovilSeeder extends Seeder
{

    static $unidadmoviles = [

        ['BJW-738',0.0,1,1],
        ['BSX-818',0.0,1,1],
        ['BUC-916',0.0,1,1],
        ['V8L-765',0.0,1,1],
        ['BUD-722',0.0,1,1],
        ['V9R-865',0.0,1,1],
        ['BUD-923',0.0,1,1],
        ['BUD-784',0.0,1,1],
        ['V9R-869',0.0,1,1],
        ['VAJ-895',0.0,1,1],
        ['VAJ-882',0.0,1,1],
        ['V9R-869',0.0,1,1],
        ['BTE-769',0.0,1,1],
        ['V8L-783',0.0,1,1],
        ['BKK-855',0.0,5,1],
        ['BKE-946',0.0,1,1],
        ['BUD-721',0.0,1,1]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$unidadmoviles as $unidadmovil) {
            DB::table('unidad_movils')->insert([
                'placa' => $unidadmovil[0],
                'kilometraje' => $unidadmovil[1],
                'modelo_id' => $unidadmovil[2],
                'color_id' => $unidadmovil[3],
            ]);
        }
    }
}
