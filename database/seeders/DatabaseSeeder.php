<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();

     $this->call(ConsesionariaSeeder::class);
     $this->call(ContratistaSeeder::class);
     $this->call(MunicipalidadeSeeder::class);
     $this->call(PrioridadSiteSeeder::class);
     $this->call(RegionGeograficaSeeder::class);
     $this->call(RegionSeeder::class);
     $this->call(RoomTypeSeeder::class);
     $this->call(TipoAccesoSeeder::class);
     $this->call(TipoEnergiaSeeder::class);
     $this->call(TipoSiteSeeder::class);
     $this->call(ZonaSeeder::class);
     $this->call(DepartamentoSeeder::class);
     $this->call(ProvinciaSeeder::class);
     $this->call(DistritoSeeder::class);
     $this->call(SiteSeeder::class);
     $this->call(EducacionSeeder::class);
     $this->call(PermissionsDemoSeeder::class);

    Model::reguard();
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
