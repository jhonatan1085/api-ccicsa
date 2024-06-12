<?php

namespace Database\Seeders;

use GuzzleHttp\Psr7\LimitStream;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    static $regions = [
        'NORTE',
        'SUR',
        'LIMA',
        'CENTRO',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$regions as $region) {
            DB::table('regions')->insert([
                'nombre' => $region
            ]);
        }
    }
}
