<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Reds extends Seeder
{
    static $reds = [
        'CORP',
        'HFC',
        'FTTH',
        'MOVIL',
        'DORSAL COSTA',
        'DORSAL SIERRA',
        'PRONATEL'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$reds as $red) {
            DB::table('reds')->insert([
                'nombre' => $red
            ]);
        }
    }
}
