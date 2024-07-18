<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsecuenciaAveriaSeeder extends Seeder
{
    static $consecuenciaAverias = [
        'Caída de servicios',
        'Niveles fuera de rango',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$consecuenciaAverias as $consecuenciaAveria) {
            DB::table('consecuencia_averias')->insert([
                'nombre' => $consecuenciaAveria
            ]);
        }
    }
}
