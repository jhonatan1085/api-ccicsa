<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDemoraSeeder extends Seeder
{
    static $tipoDemoras = [
        'Acceso al cliente Corp.',
'Avería en tramo',
'Avería masiva',
'Cable de F.O. devanado',
'Llaves Site/POP/PDI',
'Robo de Bienes CIcsa',
'Cicsa - Llaves', 
'Cicsa - Problema con Vehículo',
'Drop cruzados', 
'Cicsa - Problemas con Equipos',
'Corrida de reserva de cable F.O.',
'Falta de información en SGA / GIS',
'Ingreso a las sedes de Claro',
'Instalación de cable F.O.', 
'Mufa satura / mal acondicionada',
'Sin acceso a zona de trabajo por siniestro',
'Sin acceso a zona de trabajo por terceros',
'Sobrecarga de averías (Sin atención)',
'Suspensión de trabajos',
'Trafico > 1:15 hora',
'Zonas de difícil acceso (cámaras / Alcantarillas)',
'Averia en cola.',
'Distancia ',
'Acceso Propietario',
'Llaves Contrata',
'Bloqueo Carretera',
'Factores Climáticos',
'Prioridad Nueva Averia',
'Zona Contingente',
'Induccion Electrica',
'Soporte P.int'

];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$tipoDemoras as $tipoDemora) {
            DB::table('tipo_demoras')->insert([
                'nombre' => $tipoDemora
            ]);
        }
    }
}
