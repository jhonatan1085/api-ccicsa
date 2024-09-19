<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'api', 'name' => 'register_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_rol']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_rol']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_user']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_site']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_site']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_site']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_site']);

        Permission::create(['guard_name' => 'api', 'name' => 'list_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'detalle_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'location_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'view_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'end_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_bitacora']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_lider']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_lider']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_lider']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_lider']);


        Permission::create(['guard_name' => 'api', 'name' => 'list_cuadrilla']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_cuadrilla']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_cuadrilla']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_cuadrilla']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_und_movil']);       
        Permission::create(['guard_name' => 'api', 'name' => 'list_und_movil']);       
        Permission::create(['guard_name' => 'api', 'name' => 'edit_und_movil']);       
        Permission::create(['guard_name' => 'api', 'name' => 'delete_und_movil']);       

        Permission::create(['guard_name' => 'api', 'name' => 'settings']);


        $role3 = Role::create(['guard_name' => 'api', 'name' => 'Admin']);

        $role4 = Role::create(['guard_name' => 'api', 'name' => 'Tecnico']);
        $role5 = Role::create(['guard_name' => 'api', 'name' => 'Lider']);
        $role6 = Role::create(['guard_name' => 'api', 'name' => 'Claro']);
        $role7 = Role::create(['guard_name' => 'api', 'name' => 'Held Desk']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Jhonatan ',
            'surname' => 'Leon Leon ',
            'cel_corp' => '993206561',
            'cel_per' => '993206561',
            'dni' => '43032941',
            'gender' => '1',
            'address' => '',
            'avatar' => '',
            'email' => 'jhonatan1085@gmail.com',
            'password' => bcrypt('12345678'),
            'educacion_id' => 10,
            'zona_id' => 1
        ]);
        $user->assignRole($role3);


        $user = \App\Models\User::factory()->create([
            'name' => 'Ernelio',
            'surname' => 'García laban',
            'email' => 'e.garcialab@ccicsa.com.mx',
            'gender' => '1',
            'address' => '',
            'cel_corp' => '989595218',
            'cel_per' => '989595218',
            'dni' => '46801171',
            'zona_id' =>  16,
            'educacion_id' => 6,
            'password' => bcrypt('46801171')
        ]);
        $user->assignRole($role4);

        $user = \App\Models\User::factory()->create([
            'name'=> 'Brannco abdell',
            'surname'=> 'Rabanal valdez',
            'email'=> 'brannco09@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066230',
            'cel_per'=> '924040255',
            'dni'=> '73128120',
            'zona_id'=> 18,
            'educacion_id'=> 6,
            'password' => bcrypt('73128120')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Patricio alejandro',
            'surname'=> 'Zavaleta polo',
            'email'=> 'alejandropolo176@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '913311341',
            'cel_per'=> '986225739',
            'dni'=> '72356995',
            'zona_id'=> 1,
            'educacion_id'=>5,
            'password' => bcrypt('72356995')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Ismael',
            'surname'=> 'Rojas romero',
            'email'=> 'rorozul4@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066256',
            'cel_per'=> '921682388',
            'dni'=> '40896093',
            'zona_id'=> 15,
            'educacion_id'=>6,
            'password' => bcrypt('40896093')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jorge junior',
            'surname'=> 'Paredes lizana',
            'email'=> 'jmarxcom2@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066318',
            'cel_per'=> '916914478',
            'dni'=> '77145437',
            'zona_id'=> 15,
            'educacion_id'=> 6,
            'password' => bcrypt('77145437')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Elguer',
            'surname'=> 'Diaz colunche',
            'email'=> 'diazelguer225@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '935363808',
            'cel_per'=> '',
            'dni'=> '76326754',
            'zona_id'=> 10,
            'educacion_id'=> 6,
            'password' => bcrypt('76326754')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jorge luiz',
            'surname'=> 'Guarniz garay',
            'email'=> 'jguarnizgaray@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '951745980',
            'cel_per'=> '931224352',
            'dni'=> '46648269',
            'zona_id'=> 10,
            'educacion_id'=> 6,
            'password' => bcrypt('46648269')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jose hilder',
            'surname'=> 'Peralta inga',
            'email'=> 'josehilderperaltainga19@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '977753269',
            'cel_per'=> '977753269',
            'dni'=> '70522670',
            'zona_id'=> 2,
            'educacion_id'=> 6,
            'password' => bcrypt('70522670')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Moises',
            'surname'=> 'Quispe melo',
            'email'=> 'moisesquispe2040@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066529',
            'cel_per'=> '941478353',
            'dni'=> '40051228',
            'zona_id'=> 2,
            'educacion_id'=> 6,
            'password' => bcrypt('40051228')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jose',
            'surname'=> 'Neira adriancen',
            'email'=> 'clara00@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '989595211',
            'cel_per'=> '935626174',
            'dni'=> '46320593',
            'zona_id'=> 1,
            'educacion_id'=> 6,
            'password' => bcrypt('46320593')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Juval',
            'surname'=> 'Achic cespedes',
            'email'=> 'boyer.sincere@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '915066526',
            'dni'=> '44432688',
            'zona_id'=> 1,
            'educacion_id'=> 6,
            'password' => bcrypt('44432688')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Juberth',
            'surname'=> 'Ccenchi onofre',
            'email'=> 'kayley.ernser@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066496',
            'cel_per'=> '915066496',
            'dni'=> '44146650',
            'zona_id'=> 1,
            'educacion_id'=> 6,
            'password' => bcrypt('44146650')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jhon ',
            'surname'=> 'Collazos duran',
            'email'=> 'vboyer@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '963262229',
            'dni'=> '71863190',
            'zona_id'=> 3,
            'educacion_id'=> 6,
            'password' => bcrypt('71863190')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jhon',
            'surname'=> 'Ramirez asis',
            'email'=> 'wisoky.dante@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '987632142',
            'cel_per'=> '944805671',
            'dni'=> '05859092',
            'zona_id'=> 3,
            'educacion_id'=> 6,
            'password' => bcrypt('05859092')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Yhony alex',
            'surname'=> 'Sanchez diaz',
            'email'=> 'wbrown@example.net',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '954283701',
            'dni'=> '46045241',
            'zona_id'=> 6,
            'educacion_id'=> 6,
            'password' => bcrypt('46045241')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'William',
            'surname'=> 'Sanchez diaz',
            'email'=> 'rowe.brendan@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066389',
            'cel_per'=> '948164597',
            'dni'=> '',
            'zona_id'=> 6,
            'educacion_id'=> 6,
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Emer octavio',
            'surname'=> 'Sangay martos',
            'email'=> 'sgottlieb@example.net',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '989067522',
            'dni'=> '75716129',
            'zona_id'=> 5,
            'educacion_id'=> 6,
            'password' => bcrypt('75716129')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jesus emilio',
            'surname'=> 'Carmona cusquisiban',
            'email'=> 'iwolf@example.net',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '986650357',
            'dni'=> '44735170',
            'zona_id'=> 5,
            'educacion_id'=> 6,
            'password' => bcrypt('44735170')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Anthony ludwing',
            'surname'=> 'Castro leon',
            'email'=> 'tracey85@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '943509095',
            'dni'=> '45487113',
            'zona_id'=> 9,
            'educacion_id'=> 6,
            'password' => bcrypt('45487113')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Javier',
            'surname'=> 'Perez garay',
            'email'=> 'jo81@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '945000110',
            'dni'=> '16801640',
            'zona_id'=> 7,
            'educacion_id'=>6,
            'password' => bcrypt('16801640')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Edwar',
            'surname'=> 'Rojas romero',
            'email'=> 'eddu.r1992@gmail.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '915066483',
            'cel_per'=> '987593229',
            'dni'=> '47212444',
            'zona_id'=> 7,
            'educacion_id'=> 6,
            'password' => bcrypt('47212444')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Boris angel',
            'surname'=> 'Sanchez infante',
            'email'=> 'mcglynn.antonina@example.net',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '989065793',
            'cel_per'=> '921582953',
            'dni'=> '71997626',
            'zona_id'=> 14,
            'educacion_id'=> 6,
            'password' => bcrypt('71997626')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Julio miguel',
            'surname'=> 'Navarro agurto',
            'email'=> 'brempel@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '953236168',
            'cel_per'=> '906351116',
            'dni'=> '45859092',
            'zona_id'=> 14,
            'educacion_id'=> 6,
            'password' => bcrypt('45859092')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Davi',
            'surname'=> 'La rosa gaspar',
            'email'=> 'lambert.oconnell@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '913697944',
            'dni'=> '32975836',
            'zona_id'=> 9,
            'educacion_id'=> 6,
            'password' => bcrypt('32975836')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Nahun benhur',
            'surname'=> 'Vilela segundo',
            'email'=> 'royce.terry@example.com',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '982559511',
            'cel_per'=> '930580288',
            'dni'=> '46460054',
            'zona_id'=> 9,
            'educacion_id'=>6,
            'password' => bcrypt('46460054')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Jean paul',
            'surname'=> 'Calle mogollon',
            'email'=> 'schneider.jefferey@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '',
            'cel_per'=> '997506983',
            'dni'=> '42979476',
            'zona_id'=> 4,
            'educacion_id'=> 6,
            'password' => bcrypt('42979476')
        ]);
        $user->assignRole($role4);
        $user = \App\Models\User::factory()->create([
            'name'=> 'Moises jhonatan',
            'surname'=> 'Quiroz romero',
            'email'=> 'coby.keeling@example.org',
            'gender'=> '1',
            'address'=> '',
            'cel_corp'=> '982559510',
            'cel_per'=> '982559510',
            'dni'=> '44183404',
            'zona_id'=> 4,
            'educacion_id'=> 6,
            'password' => bcrypt('44183404')
        ]);
        $user->assignRole($role4);

    
        $user = \App\Models\User::factory()->create([
            'name' => 'LENIN',
            'surname' => 'RODRIGUEZ',
            'cel_corp' => '123456',
            'cel_per' => '123456',
            'dni' => '12345678',
            'gender' => '1',
            'password' => bcrypt('12345678'),
            'zona_id' => 1
        ]);
        $user->assignRole($role5);

        $user = \App\Models\User::factory()->create([
            'name' => 'ROBERTO',
            'surname' => 'ZAPATA',
            'cel_corp' => '123456',
            'cel_per' => '123456',
            'dni' => '12345678',
            'gender' => '1',
            'password' => bcrypt('12345678'),
            'zona_id' => 1
        ]);
        $user->assignRole($role5);


        $user = \App\Models\User::factory()->create([
            'name'=> 'Alexandra',
            'surname'=> 'Cornejo bardales',
            'email'=> 'alexandracornejobardales@gmail.com',
            'gender'=> '0',
            'address'=> '',
            'cel_corp'=> '997740176',
            'dni'=> '72889115',
            'zona_id'=> 1,
            'educacion_id'=> 8,
            'password' => bcrypt('72889115')
        ]);
        $user->assignRole($role7);

    }
}
