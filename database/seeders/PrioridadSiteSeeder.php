<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioridadSiteSeeder extends Seeder
{
    static $prioridadsites = [
        'CONVERGENTE 1',
        'CONVERGENTE 2',
        'SEDE ADMINISTRATIVA',
        'LOCAL COMERCIAL',
        'TERMINALES',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$prioridadsites as $prioridadsite) {
            DB::table('prioridad_sites')->insert([
                'nombre' => $prioridadsite
            ]);
        }
    }
}
