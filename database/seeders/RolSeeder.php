<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'nivel' => 1,
            'nombre' => 'Administrador',
        ]);
        DB::table('roles')->insert([
            'nivel' => 2,
            'nombre' => 'Atencion',
        ]);
        DB::table('roles')->insert([
            'nivel' => 3,
            'nombre' => 'Administrador Juzgado',
        ]);
        DB::table('roles')->insert([
            'nivel' => 4,
            'nombre' => 'Presidencia',
        ]);
    }
}
