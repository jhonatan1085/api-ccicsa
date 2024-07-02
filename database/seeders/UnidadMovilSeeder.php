<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMovilSeeder extends Seeder
{

    static $unidadmoviles = [
        "BJW-738",
        "BSX-818",
        "BUC-916",
        "V8L-765", 
        "BUD-722",
        "V9R -865",
        "BUD-923",
        "BUD -784",
        "V9R-869",
        "VAJ-895",
        "VAJ-882",
        "V8L-783",
        "BKE-872",
        "BDZ-635",
        "BDY-091",
        "BUD-777"    
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$unidadmoviles as $unidadmovil) {
            DB::table('unidad_movils')->insert([
                'placa' => $unidadmovil
            ]);
        }
    }
}
