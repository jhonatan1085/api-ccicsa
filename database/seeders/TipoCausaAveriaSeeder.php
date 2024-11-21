<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoCausaAveriaSeeder extends Seeder
{
    static $tipoDemoras = [
        'Contratas Claro',
        'CRQ (Ventana)',
        'Deterioro de P.Ext.',
        'Vandalismo',
        'Terceros',
        'Roedor',
        'P.Int/Ext o Energía',
        'FTTH',
        'Desastres Naturales',
        'Clientes'
    ];
    public function run(): void
    {
        foreach (self::$tipoDemoras as $tipoDemora) {
            DB::table('tipo_causa_averias')->insert([
                'nombre' => $tipoDemora
            ]);
        }
    }
}
