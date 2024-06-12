<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAccesoSeeder extends Seeder
{
    static $tipoaccesos = [
        '2G-3G-4G',
        '3G-4G',
        '2G',
        '3G',
        '2G-3G-4G-5G',
        '2G-3G',
        '3G-4G-5G',
        '4G',
        '2G-4G',
        '2G-3G-4G-TDD',
        '2G-3G-5G',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        foreach (self::$tipoaccesos as $tipoacceso) {
            DB::table('tipo_accesos')->insert([
                'nombre' => $tipoacceso
            ]);
        }
    }
}
