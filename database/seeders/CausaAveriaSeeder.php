<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CausaAveriaSeeder extends Seeder
{
    static $causaAverias = [
        'Cuentas Invertidas 1',
        'Cuentas Invertidas 2',
        'Habilitación de hilos',
        'Migración 1',
        'Migración 2',
        'Microcortes',
        'Cables o Mufa siniestrado',
        'Robo de terminal(Mufa,FAT)',
        'Sabotaje',
        'Acometida rota',
        'Afectación de cable aéreo (cruce, vehículo)',
        'Cambio de postes eléctricos',
        'Daño de Cola de servicio',
        'Incendio',
        'Obras civiles de terceros (Excavaciones)',
        'Poda de árboles',
        'Poste Siniestrado',
        'Drop suelto',
        'Problema de Inhouse',
        'Hilos rotos (Mufa, Bufer)',
        'Cable Drop/MPO roto',
        'Cable F.O roto por terceros',
        'Normalización de cables',
        'Cable suelto ',
        'Roedor',
        'Falsa avería',
        'Jumper en el Pop/Site/Cliente',
        'Problema de energía',
        'Problema de P. Int. (equipos/tarjetas/Accesos)',
        'Descarte PEXT CLARO',
        'Fat Sin Potencia',
        'FAT averiado',
        'Camara(siniestrada, marco y tapa)/inundada',
        'Uso de Bandeja / Mondragón',
        'Conectores deteriorados / sucios ',
        'Conectores sulfatados',
        'Ferretería deteriorada por corrosión ',
        'Mufa saturada y/o mal acondicionada',
        'Pigtail/Jumper/duplex deterioro',
        'Hilos rotos (Mufa, Bufer)',
        'Suspendido por VM',
        'Deslizamiento de tierra',
        'Huaicos / lluvias/Incendio Forestal',
        'Incendio',
        'Hilo Atenuado / Rotos (Manipulación de terceros)',
        'Manipulación de terceros POP/Site/Mufas/Clientes',
        'Derivados',
        'Problema de construccion FTTH',
        'Hilos roto en caja panduit',
        'Manipulación de Cliente (panduit / Cable)',
        'Obras civiles dentro del local Cliente',
        'Caja panduit / deteriorados',
        'Avería en tramo',
        'Monitoreo',
        'Daño de Cola de servicio'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$causaAverias as $causaAveria) {
            DB::table('causa_averias')->insert([
                'nombre' => $causaAveria
            ]);
        }
    }
}
