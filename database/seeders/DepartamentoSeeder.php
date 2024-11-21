<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    static $departamentos = [
        'AMAZONAS',
'ANCASH',
'CAJAMARCA',
'LA LIBERTAD',
'LAMBAYEQUE',
'PIURA',
'TUMBES',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$departamentos as $departamento) {
            DB::table('departamentos')->insert([
                'nombre' => $departamento
            ]);
        }
    }
}
