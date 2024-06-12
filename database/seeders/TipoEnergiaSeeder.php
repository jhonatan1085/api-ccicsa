<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEnergiaSeeder extends Seeder
{
    static $tipoenergias = [
        'AC',
        'AC / RESERVA',
        'PANELES SOLARES',
        'AC/RESERVA',
        'PRIME',
        'GREEN CONTROLLER',
        'PRIME/PANELES SOLARES',
        'IMPLEMENTACION',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoenergias as $tipoenergia) {
            DB::table('tipo_energias')->insert([
                'nombre' => $tipoenergia
            ]);
        }
    }
}
