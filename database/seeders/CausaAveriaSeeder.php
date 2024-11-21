<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CausaAveriaSeeder extends Seeder
{
    static $causaAverias = [
        ['Cuentas Invertidas 1',1],
        ['Cuentas Invertidas 2',2],
        ['Manipulacion Elem. Pasivo Externo MUFAs,otros.',3],
        ['Vandalismo (Sabotaje,Robos de Mufa, Robos de cable, Robo de MYT)',4],
        ['Cable FO Roto por Vano bajo',5],
        ['Reemplazo de poste por Concesionaria',5],
        ['Daño de Cola de servicio',5],
        ['Obras civiles de terceros (Excavaciones)',5],
        ['Poda de árboles de terceros',5],
        ['Ataque de Animales Silvestres (Roedores, aves, Insectos)',6],
        ['Falsa Avería',7],
        ['Manipulacion Elem. Pasivo Interior GPS,GPS2,Opticom',7],
        ['Manipulación Elem. Pasivo Externo (Fat, Xbox, Hbox, etc)',8],
        ['Siniestros, Accidentes de Transito, Corto Circuito etc.',5],
        ['Ferretería obsoleta',3],
        ['Mufa saturada y/o mal acondicionada',3],
        ['Fenomenos Naturales (Sismos,Huaycos, Caudal en Rios, Indencio etc)',9],
        ['Elemento de RED FTTH averiado',1],
        ['Resequedad FO (Mufa, Bandeja, Buffer)',10],
        ['Maniobras NO Autorizadas en la Red',10],
        ['Monitoreo',2],
        ['Daño de Cola de servicio',5],
        ['Cable Drop Roto/Averiado',5],
        ['Avería en tramo',5],
        ['Derivados',1],
        ['Descarte PEXT CLARO',7],
        ['Problema de P. Int. (equipos/tarjetas/Accesos)',7],
        ['Problema de energía',7],
        ['Cable suelto ',5],
        ['Acometida rota',5],
        ['Cable MPO Roto/Averiado',5]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$causaAverias as $causaAveria) {
            DB::table('causa_averias')->insert([
                'nombre' => $causaAveria[0],
                'tipo_causa_averia_id' => $causaAveria[1]
            ]);
        }
    }
}
