<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    static $provincias = [
        ['TRUJILLO', 1],
        ['SANTA', 2],
        ['ANTONIO RAYMONDI', 2],
        ['TUMBES', 3],
        ['PATAZ', 1],
        ['CAJAMARCA', 4],
        ['JAEN', 4],
        ['CHICLAYO', 5],
        ['GRAN CHIMU', 1],
        ['CHACHAPOYAS', 6],
        ['ZARUMILLA', 3],
        ['PIURA', 7],
        ['AIJA', 2],
        ['SANCHEZ CARRION', 1],
        ['SANTIAGO DE CHUCO', 1],
        ['TALARA', 7],
        ['SULLANA', 7],
        ['PAITA', 7],
        ['HUARAZ', 2],
        ['HUALGAYOC', 4],
        ['HUARI', 2],
        ['BAGUA', 6],
        ['AYABACA', 7],
        ['LUYA', 6],
        ['ASCOPE', 1],
        ['SIHUAS', 2],
        ['UTCUBAMBA', 6],
        ['CORONGO', 2],
        ['SECHURA', 7],
        ['SAN IGNACIO', 4],
        ['MORROPON', 7],
        ['CAJABAMBA', 4],
        ['SAN MIGUEL', 4],
        ['BOLIVAR', 1],
        ['CELENDIN', 4],
        ['PALLASCA', 2],
        ['CONTRALMIRANTE VILLAR', 3],
        ['HUARMEY', 2],
        ['LAMBAYEQUE', 5],
        ['VIRU', 1],
        ['FERREÑAFE', 5],
        ['HUAYLAS', 2],
        ['JULCAN', 1],
        ['CARHUAZ', 2],
        ['CASMA', 2],
        ['CONTUMAZA', 4],
        ['CHOTA', 4],
        ['OTUZCO', 1],
        ['ASUNCION', 2],
        ['CARLOS FERMIN FITZCARRALD', 2],
        ['MARISCAL LUZURIAGA', 2],
        ['SAN MARCOS', 4],
        ['BOLOGNESI', 2],
        ['CHEPEN', 1],
        ['RODRIGUEZ DE MENDOZA', 6],
        ['PACASMAYO', 1],
        ['RECUAY', 2],
        ['OCROS', 2],
        ['CUTERVO', 4],
        ['BONGARA', 6],
        ['HUANCABAMBA', 7],
        ['MARAÑON', 8],
        ['SANTA CRUZ', 4],
        ['YUNGAY', 2],
        ['DATEM DEL MARAÑON', 6],
        ['SAN PABLO', 4],
        ['POMABAMBA', 2],
        ['CONDORCANQUI', 6],
        ['N/D', 9],
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
