<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducacionSeeder extends Seeder
{
    static $educacions = [
        'ED. PRIMARIA INCOMPLETA',
        'ED. PRIMARIA COMPLETA',
        'ED. SECUND INCOMPLETA',
        'ED. SECUND COMPLETA',
        'ED. SUPERIOR TECNICA INCOMPLETA',
        'ED. SUPERIOR TECNICA COMPLETA',
        'ED. UNIVERSITARIA INCOMPLETA',
        'ED. UNIVERSITARIA COMPLETA',
        'GRADO BACHILLER',
        'TITULADO',
        'MAESTRIA INCOMPLETA',
        'MAESTRIA COMPLETA',
        'GRADO DE MAESTRIA',
        'DOCTORADO INCOMPLETO',
        'DOCTORADO COMPLETO',
        'GRADO DE DOCTOR',
        'N/D',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$educacions as $educacion) {
            DB::table('educacions')->insert([
                'nombre' => $educacion
            ]);
        }
    }
}
