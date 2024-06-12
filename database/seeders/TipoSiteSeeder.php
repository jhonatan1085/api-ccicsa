<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSiteSeeder extends Seeder
{
    static $tiposites = [
        'BASE CICSA',
        'CORPORATIVO/TERMINAL',
        'DORSAL',
        'DORSAL/CORPORATIVO',
        'DORSAL/IPRAN',
        'DORSAL/IPRAN/CORPORATIVO',
        'DORSAL/IPRAN/TDD/CORPORATIVO',
        'DORSAL/TDD',
        'IPRAN/NODAL/CORPORATIVO',
        'IPRAN/NODAL/TDD/CORPORATIVO',
        'IPRAN/TDD/CORPORATIVO/TERMINAL',
        'NAT',
        'NODAL',
        'NODAL/ CORPORATIVO',
        'NODAL/CORPORATIVO',
        'NODAL/CORPORATIVO/TERMINAL',
        'NODAL/TDD',
        'NODAL/TDD/CORPORATIVO',
        'NODAL/TDD/CORPORATIVO/TERMINAL',
        'NODO',
        'NODO FO / MW',
        'NODO FO/ MW / CORPORATIVO',
        'NODO IP RAN / FO / OLT',
        'NODO/CORPORATIVO/TERMINAL',
        'PDI',
        'POP',
        'POP/DORSAL/IPRAN',
        'SEDE COMERCIAL',
        'SEDE COMERCIAL/CORPORATIVO',
        'SEDE TECNOLOGICA',
        'TDD/CORPORATIVO/TERMINAL',
        'TDD/TERMINAL',
        'TERMINAL',
        'TERMINAL - SITE AÚN NO LO VEMOS',
        'TERMINAL (NO LO VE CICSA)',
        'TERMINAL (no lo vemos)',
        'TERMINAL(no asignado)',
        'TERMINAL(NUEVO)',
        'TERMINAL/ CORPORATIVO',
        'N/D'
       
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
