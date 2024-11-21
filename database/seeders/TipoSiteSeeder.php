<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSiteSeeder extends Seeder
{
    static $tiposites = [
        'TERMINAL',
        'DORSAL',
        'NODAL',
        'NAT',
        'OLT',
        'POP' 
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tiposites as $tiposite) {
            DB::table('tipo_sites')->insert([
                'nombre' => $tiposite
            ]);
        }
    }
}
