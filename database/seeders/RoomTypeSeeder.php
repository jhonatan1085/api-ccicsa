<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    static $roomtypes = [
        'OUTDOOR',
        'PICO',
        'RRU-IN',
        'INDOOR',
        'RRU-OUT',
        'POSTE',
        'N/D'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$roomtypes as $roomtype) {
            DB::table('room_types')->insert([
                'nombre' => $roomtype
            ]);
        }
    }
}
