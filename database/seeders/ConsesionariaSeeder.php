<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsesionariaSeeder extends Seeder
{
    static $consesionarias = [
        'HIDRANDINA S.A.',
        'HIDRANDINA',
        'ENOSA',
        'ELECTRO ORIENTE',
        'ENSA',
        'MUNICIPALIDAD',
        'MINA BARRICK',
        'TORRES UNIDAS',
        'MINA ANTAMINA',
        'PANEL SOLAR',
        'MINA EL CEDRO',
        'EMSEU',
        'ATC',
        'PHOENIX TOWER',
        'CENTRO COMERCIAL',
        'CHAVIMOCHIC',
        'HOTEL',
        'GRUPO ELECTROGENO',
        'TDP',
        'EILHICHA S.A.',
        'ENTEL',
        'mina',
        'MINA EL TORO',
        'HORTIFRUT',
        'FUNDO ACP',
        'FUNDO COMPOSITAN',
        'MINA GOLD FIELDS',
        'MINA LA ZANJA',
        'MINA MARSA',
        'MINA HORIZONTE',
        'MINA YANACOCHA',
        'PETRO PERU',
        '-',
        'MINA LA ARENA',
        'COELVISAC',
        'MINA PIERINA',
        'PLANTA VIRU',
        'MINA PODEROSA',
        'PESQUERA DIAMANTE',
        'ELECTRO TOCACHE',
        'SOCIEDAD AGRICOLA VIRU',
        'ADINELSA',
        'ELECTRONOROESTE S.A.',
        'STATKRAFT PERU S.A.',
        'ELECTRO NORTE',
        'HIADRAND',
        'NUEVO',
        'YANACOCHA',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$consesionarias as $consesionaria) {
            DB::table('consesionarias')->insert([
                'nombre' => $consesionaria
            ]);
        }
    }
}
