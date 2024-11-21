<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAverias extends Seeder
{
    static $tipoaverias = [
        'Preventivo',
        'Correctivo',
        'Sinergia'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoaverias as $tipoaveria) {
            DB::table('tipo_averias')->insert([
                'nombre' => $tipoaveria
            ]);
        }
    }
}
