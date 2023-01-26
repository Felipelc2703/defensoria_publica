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
    }
}
