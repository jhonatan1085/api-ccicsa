<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPlantaSeeder extends Seeder
{
    static $tipoplantas = [
        'Planta Interna',
        'Planta Externa'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoplantas as $tipoplanta) {
            DB::table('tipo_plantas')->insert([
                'nombre' => $tipoplanta
            ]);
        }
    }
}
