<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaSeeder extends Seeder
{
    static $zonas = [
       
        ['AMAZONAS',1],
        ['CAJAMARCA',1],
        ['CHICLAYO',1],
        ['CHIMBOTE',1],
        ['CHOTA',1],
        ['HUARAZ',1],
        ['JAEN',1],
        ['PIURA',1],
        ['TRUJILLO',1],
        ['TUMBES',1],
        ['PUCALLPA',1],
        ['IQUITOS',1],
        ['TALARA',1],
        ['HUANCABAMBA',1],
        ['PEDRO RUIZ',1],
       ['HUAMACHUCO',1],
        ['ARAGOSTAY',1],
        
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$zonas as $zona) {
            DB::table('zonas')->insert([
                'nombre' => $zona[0],
                'region_id' => $zona[1]
            ]);
        }
    }
}
