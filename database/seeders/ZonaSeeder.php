<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaSeeder extends Seeder
{
    static $zonas = [
        'TRUJILLO',
        'CHIMBOTE',
        'HUARAZ',
        'TUMBES',
        'CAJAMARCA',
        'JAEN',
        'CHICLAYO',
        'AMAZONAS',
        'PIURA',
        'CHOTA',
        'PUCALLPA',
        'IQUITOS',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$zonas as $zona) {
            DB::table('zonas')->insert([
                'nombre' => $zona
            ]);
        }
    }
}
