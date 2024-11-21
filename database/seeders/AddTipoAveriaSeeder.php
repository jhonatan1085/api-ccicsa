<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddTipoAveriaSeeder extends Seeder
{
    static $tipoAverias = [
        ['Preventivo','Preventivo FO'],
        ['Correctivo','Avería FO'],
        ['Sinergia','Sinergia']
    ];   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoAverias as $tipoAveria) {
            DB::table('tipo_averias')
            ->where('nombre', $tipoAveria[0])
            ->update([
                'incidencia' => $tipoAveria[1]
            ]);
        }
    }
}
