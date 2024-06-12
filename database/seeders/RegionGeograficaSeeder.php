<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionGeograficaSeeder extends Seeder
{
    static $regionsgeos = [
        'COSTA',
        'SIERRA',
        'SELVA',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$regionsgeos as $regionsgeo) {
            DB::table('region_geograficas')->insert([
                'nombre' => $regionsgeo
            ]);
        }
    }
}
