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
       Permission::create(['guard_name' => 'api','name' => 'register_rol']);
       Permission::create(['guard_name' => 'api','name' => 'list_rol']);
       Permission::create(['guard_name' => 'api','name' => 'edit_rol']);
       Permission::create(['guard_name' => 'api','name' => 'delete_rol']);

       Permission::create(['guard_name' => 'api','name' => 'register_doctor']);
       Permission::create(['guard_name' => 'api','name' => 'list_doctor']);
       Permission::create(['guard_name' => 'api','name' => 'edit_doctor']);
       Permission::create(['guard_name' => 'api','name' => 'delete_doctor']);
       Permission::create(['guard_name' => 'api','name' => 'profile_doctor']);

       Permission::create(['guard_name' => 'api','name' => 'register_patient']);
       Permission::create(['guard_name' => 'api','name' => 'list_patient']);
       Permission::create(['guard_name' => 'api','name' => 'edit_patient']);
       Permission::create(['guard_name' => 'api','name' => 'delete_patient']);
       Permission::create(['guard_name' => 'api','name' => 'profile_patient']);

       Permission::create(['guard_name' => 'api','name' => 'register_staff']);
       Permission::create(['guard_name' => 'api','name' => 'list_staff']);
       Permission::create(['guard_name' => 'api','name' => 'edit_staff']);
       Permission::create(['guard_name' => 'api','name' => 'delete_staff']);

       Permission::create(['guard_name' => 'api','name' => 'register_appointment']);
       Permission::create(['guard_name' => 'api','name' => 'list_appointment']);
       Permission::create(['guard_name' => 'api','name' => 'edit_appointment']);
       Permission::create(['guard_name' => 'api','name' => 'delete_appointment']);

       Permission::create(['guard_name' => 'api','name' => 'register_specialty']);
       Permission::create(['guard_name' => 'api','name' => 'list_specialty']);
       Permission::create(['guard_name' => 'api','name' => 'edit_specialty']);
       Permission::create(['guard_name' => 'api','name' => 'delete_specialty']);

       Permission::create(['guard_name' => 'api','name' => 'show_payment']);
       Permission::create(['guard_name' => 'api','name' => 'edit_payment']);

       Permission::create(['guard_name' => 'api','name' => 'activitie']);
       Permission::create(['guard_name' => 'api','name' => 'calendar']);

       Permission::create(['guard_name' => 'api','name' => 'expense_report']);
       Permission::create(['guard_name' => 'api','name' => 'invoice_report']);

       Permission::create(['guard_name' => 'api','name' => 'settings']);


       $role3 = Role::create(['guard_name' => 'api','name' => 'Admin']);
       Role::create(['guard_name' => 'api','name' => 'Held Desk']);
       $role4 = Role::create(['guard_name' => 'api','name' => 'Tecnico']);
       $role5 = Role::create(['guard_name' => 'api','name' => 'Lider']);



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
        'name' => 'MOISES JHONATAN',
        'surname' => 'QUIROZ ROMERO',
        'cel_corp' => '982559510',
        'cel_per' => '982559510',
        'dni' => '44183404',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 4
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JEAN PAUL',
        'surname' => 'CALLE MOGOLLON',
        'cel_per' => '997506983',
        'dni' => '42979476',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 4
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'NAHUN BENHUR',
        'surname' => 'VILELA SEGUNDO',
        'cel_corp' => '982559511',
        'cel_per' => '930580288',
        'dni' => '46460054',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 9
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'DAVI',
        'surname' => 'LA ROSA GASPAR',
        'cel_per' => '913697944',
        'dni' => '32975836',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 9
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JULIO MIGUEL',
        'surname' => 'NAVARRO AGURTO',
        'cel_corp' => '953236168',
        'cel_per' => '906351116',
        'dni' => '45859092',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 14
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'BORIS ANGEL',
        'surname' => 'SANCHEZ INFANTE',
        'cel_corp' => '989065793',
        'cel_per' => '921582953',
        'dni' => '71997626',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 14
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'EDWAR',
        'surname' => 'ROJAS ROMERO',
        'cel_corp' => '915066483',
        'cel_per' => '987593229',
        'dni' => '47212444',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 7
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JAVIER',
        'surname' => 'PEREZ GARAY',
        'cel_per' => '945000110',
        'dni' => '16801640',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 7
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'ANTHONY LUDWING',
        'surname' => 'CASTRO LEON',
        'cel_per' => '943509095',
        'dni' => '45487113',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 9
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'Jesus emilio',
        'surname' => 'Carmona cusquisiban',
        'cel_per' => '986650357',
        'dni' => '44735170',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 5
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'Emer octavio',
        'surname' => 'Sangay martos',
        'cel_per' => '989067522',
        'dni' => '75716129',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 5
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'WILLIAM',
        'surname' => 'SANCHEZ DIAZ',
        'cel_corp' => '915066389',
        'cel_per' => '948164597',
        'dni' => '',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 6
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'YHONY ALEX',
        'surname' => 'SANCHEZ DIAZ',
        'cel_per' => '954283701',
        'dni' => '46045241',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 6
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JHON ',
        'surname' => 'RAMIREZ ASIS',
        'cel_corp' => '987632142',
        'cel_per' => '944805671',
        'dni' => '05859092',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 3
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JHON ',
        'surname' => 'COLLAZOS DURAN',
        'cel_per' => '963262229',
        'dni' => '71863190',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 3
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JUBERTH',
        'surname' => 'CCENCHI ONOFRE',
        'cel_corp' => '915066496',
        'cel_per' => '915066496',
        'dni' => '44146650',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 1
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JUVAL',
        'surname' => 'ACHIC CESPEDES',
        'cel_per' => '915066526',
        'dni' => '44432688',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 1
    ]);
    $user->assignRole($role4);

    $user = \App\Models\User::factory()->create([
        'name' => 'JOSE',
        'surname' => 'NEIRA ADRIANCEN',
        'cel_corp' => '989595211',
        'cel_per' => '935626174',
        'dni' => '46320593',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 1
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
        'dni' => '87654321',
        'gender' => '1',
        'password' => bcrypt('12345678'),
        'zona_id' => 1
    ]);
    $user->assignRole($role5);


   }
}