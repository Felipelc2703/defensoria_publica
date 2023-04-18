<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Kevin Corona',
            'clave' => 'KevinVanHalen',
            'email' => 'keviinvanhalen@gmail.com',
            'password' => 'password',
            'centro_atencion_id' => 1,
            'rol_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Marco Polo',
            'clave' => 'Polo',
            'email' => 'marcopoloolivaresgonzalez@gmail.com',
            'password' => 'polo123',
            'centro_atencion_id' => 1,
            'rol_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Felipe Lopez',
            'clave' => 'FelipeLC',
            'email' => 'felipe.loezc188@gmail.com',
            'password' => '123456',
            'centro_atencion_id' => 1,
            'rol_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Administrador',
            'clave' => 'administrador',
            'email' => 'admin@gmail.com',
            'password' => 'fsLA8C!V',
            'centro_atencion_id' => 1,
            'rol_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Juzgado Primero Civil',
            'clave' => 'primerocivil',
            'email' => '1civil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 1,
            'rol_id' => 3,
            'juez_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Segundo Civil',
            'clave' => 'segundocivil',
            'email' => '2civil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 2,
            'rol_id' => 3,
            'juez_id' => 2,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Tercero Civil',
            'clave' => 'tercerocivil',
            'email' => '3civil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 3,
            'rol_id' => 3,
            'juez_id' => 3,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Cuarto Civil',
            'clave' => 'cuartocivil',
            'email' => '4civil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 4,
            'rol_id' => 3,
            'juez_id' => 4,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Quinto Civil',
            'clave' => 'quintocivil',
            'email' => '5civil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 5,
            'rol_id' => 3,
            'juez_id' => 5,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Sexto Mercantil',
            'clave' => 'sextomercantil',
            'email' => '6mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 6,
            'rol_id' => 3,
            'juez_id' => 6,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Septimo Mercantil',
            'clave' => 'septimomercantil',
            'email' => '7mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 7,
            'rol_id' => 3,
            'juez_id' => 7,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Octavo Mercantil',
            'clave' => 'octavomercantil',
            'email' => '8mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 8,
            'rol_id' => 3,
            'juez_id' => 8,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Noveno Mercantil',
            'clave' => 'novenomercantil',
            'email' => '9mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 9,
            'rol_id' => 3,
            'juez_id' => 9,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Décimo Mercantil',
            'clave' => 'decimomercantil',
            'email' => '10mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 10,
            'rol_id' => 3,
            'juez_id' => 10,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Décimo Primero Mercantil',
            'clave' => 'decimoprimeromercantil',
            'email' => '11mercantil@gmail.com',
            'password' => 'password',
            'juzgado_id' => 11,
            'rol_id' => 3,
            'juez_id' => 11,
        ]);

        DB::table('users')->insert([
            'name' => 'Juzgado Primero Familiar',
            'clave' => 'primerofamiliar',
            'email' => '1familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 12,
            'rol_id' => 3,
            'juez_id' => 12,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Segundo Familiar',
            'clave' => 'segundofamiliar',
            'email' => '2familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 13,
            'rol_id' => 3,
            'juez_id' => 13,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Tercero Familiar',
            'clave' => 'tercerofamiliar',
            'email' => '3familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 14,
            'rol_id' => 3,
            'juez_id' => 14,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Cuarto Familiar',
            'clave' => 'cuartofamiliar',
            'email' => '4familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 15,
            'rol_id' => 3,
            'juez_id' => 15,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Quinto Familiar',
            'clave' => 'quintofamiliar',
            'email' => '5familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 16,
            'rol_id' => 3,
            'juez_id' => 16,
        ]);
        DB::table('users')->insert([
            'name' => 'Juzgado Sexto Familiar',
            'clave' => 'sextofamiliar',
            'email' => '6familiar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 17,
            'rol_id' => 3,
            'juez_id' => 17,
        ]);

        DB::table('users')->insert([
            'name' => 'Minerva Mejía',
            'clave' => 'minerva',
            'email' => '1oralfamiliar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 18,
            'rol_id' => 3,
            'juez_id' => 18,
        ]);
        DB::table('users')->insert([
            'name' => 'Olga Pérez',
            'clave' => 'olga',
            'email' => '2oralfamiliar@gmail.com',
            'password' => 'password',
            'juzgado_id' => 18,
            'rol_id' => 3,
            'juez_id' => 19,
        ]);
        DB::table('users')->insert([
            'name' => 'Presidencia',
            'clave' => 'presidencia',
            'email' => 'presidencia@gmail.com',
            'password' => 'password',
            // 'juzgado_id' => 18,
            'rol_id' => 4,
            // 'juez_id' => 19,
        ]);
    }
}
