<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContratistaSeeder extends Seeder
{
    static $contratistas = [
        'CICSA',
        'ECYTEL',
        'SAFESA',
        'VARVELA',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$contratistas as $contratista) {
            DB::table('contratistas')->insert([
                'nombre' => $contratista
            ]);
        }
    }
}
