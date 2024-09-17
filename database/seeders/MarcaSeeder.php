<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    static $marcas = [
        'Toyota',
        'Nissan',
        'Mitsubishi',
        'Chevrolet',
        'JAC',
    ];  
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$marcas as $marca) {
            DB::table('marcas')->insert([
                'nombre' => $marca
            ]);
        }
    }
}
