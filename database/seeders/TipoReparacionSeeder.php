<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoReparacionSeeder extends Seeder
{
    static $tipoReparacions = [
        'Provisional',
        'Definitivo',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoReparacions as $tipoReparacion) {
            DB::table('tipo_reparacions')->insert([
                'nombre' => $tipoReparacion
            ]);
        }
    }
}
