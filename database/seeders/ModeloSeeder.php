<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloSeeder extends Seeder
{
    static $modelos = [

        ['Hilux',1],
        ['L200',2],
        ['NP300',3],
        ['NP400',4],
        ['FRISON T8',5],
    ];  
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$modelos as $modelo) {
            DB::table('modelos')->insert([
                'nombre' => $modelo[0],
                'marca_id' => $modelo[1]
            ]);
        }
    }
}
