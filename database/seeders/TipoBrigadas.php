<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBrigadas extends Seeder
{
    static $tipobrigadas = [
        'BRIGADA',
        'MEDIA BRIGADA'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipobrigadas as $tipobrigada) {
            DB::table('tipo_brigadas')->insert([
                'nombre' => $tipobrigada
            ]);
        }
    }
}
