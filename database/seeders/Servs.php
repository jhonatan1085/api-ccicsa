<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Servs extends Seeder
{
    static $servs = [
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
        foreach (self::$servs as $serv) {
            DB::table('servs')->insert([
                'nombre' => $serv
            ]);
        }
    }
}
