<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    static $provincias = [
        ['CHACHAPOYAS',1],
        ['BAGUA',1],
        ['UTCUBAMBA',1],
        ['RODRIGUEZ DE MENDOZA',1],
        ['BONGARA',1],
        ['LUYA',1],
        ['CONDORCANQUI',1],
        ['CASMA',2],
        ['SANTA',2],
        ['RECUAY',2],
        ['HUAYLAS',2],
        ['HUARAZ',2],
        ['HUARI',2],
        ['PALLASCA',2],
        ['HUARMEY',2],
        ['MARISCAL LUZURIAGA',2],
        ['SIHUAS',2],
        ['CARLOS FERMIN FITZCARRALD',2],
        ['ANTONIO RAYMONDI',2],
        ['BOLOGNESI',2],
        ['YUNGAY',2],
        ['CARHUAZ',2],
        ['POMABAMBA',2],
        ['AIJA',2],
        ['ASUNCION',2],
        ['OCROS',2],
        ['CORONGO',2],
        ['CHIMBOTE',2],
        ['CUTERVO',3],
        ['CAJAMARCA',3],
        ['SAN IGNACIO',3],
        ['JAEN',3],
        ['CHOTA',3],
        ['CELENDIN',3],
        ['SAN MARCOS',3],
        ['CONTUMAZA',3],
        ['SAN PABLO',3],
        ['HUALGAYOC',3],
        ['SANTA CRUZ',3],
        ['CAJABAMBA',3],
        ['SAN MIGUEL',3],
        ['VIRU',4],
        ['TRUJILLO',4],
        ['SANCHEZ CARRION',4],
        ['PATAZ',4],
        ['CHEPEN',4],
        ['PACASMAYO',4],
        ['ASCOPE',4],
        ['GRAN CHIMU',4],
        ['OTUZCO',4],
        ['SANTIAGO DE CHUCO',4],
        ['JULCAN',4],
        ['BOLIVAR',4],
        ['LAMBAYEQUE',5],
        ['CHICLAYO',5],
        ['FERREÑAFE',5],
        ['PIURA',6],
        ['HUANCABAMBA',6],
        ['SULLANA',6],
        ['TALARA',6],
        ['MORROPON',6],
        ['AYABACA',6],
        ['PAITA',6],
        ['SECHURA',6],
        ['CHULUCANAS',6],
        ['CONTRALMIRANTE VILLAR',7],
        ['TUMBES',7],
        ['ZARUMILLA',7],
        ['N/D', 8],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$provincias as $provincia) {
            DB::table('provincias')->insert([
                'nombre' => $provincia[0],
                'departamento_id' => $provincia[1]
            ]);
        }
    }
}
