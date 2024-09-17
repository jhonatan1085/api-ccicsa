<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMovilUserSeeder extends Seeder
{
    static $unidadmovilesusers = [

        [3,10],
        [19,5],
        [22,4],
        [10,11],
        [8,15],
        [5,14],
        [15,7],
        [17,6],
        [2,8],
        [26,16],
        [24,17],
        [13,9],
        [27,1],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$unidadmovilesusers as $unidadmovilesuser) {
            DB::table('unidad_movil_user')->insert([
                'fecha_alta' => now(),
                'km_inicial' => 0,
                'user_id' => $unidadmovilesuser[0],
                'unidad_movil_id' => $unidadmovilesuser[1],
            ]);
        }
    }
}
