<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtencionSeeder extends Seeder
{


    static $atencions = [

        ['Se informa la avería',1,'1'],
        ['Brigada en sitio',2,'1'],
        ['Acceso concedido',3,'1'],
        ['Se realiza la medición',4,'1'],
        ['Se ubica el punto de avería',5,'1'],
        ['Inicio de fusión cable',6,'1'],
        ['Se solicita la validación del servicio',7,'1'],
        ['Se confirma la validación',8,'1'],
        ['Se finaliza las fusiones',9,'1'],
        ['Se culmina trabajo la brigada procede a retirarse',10,'1'],
    ];        
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$atencions as $atencion) {
            DB::table('atencions')->insert([
                'descripcion' => $atencion[0],
                'orden' => $atencion[1],
                'estado' => $atencion[2]
            ]);
        }
    }
}
