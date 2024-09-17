<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    static $colores = [
        'Blanco',
        'Negro'
    ];   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$colores as $color) {
            DB::table('colors')->insert([
                'nombre' => $color
            ]);
        }
    }
}
