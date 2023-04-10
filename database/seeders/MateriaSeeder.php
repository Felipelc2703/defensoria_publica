<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materias')->insert([
            'nombre' => 'Civil',
        ]);
        DB::table('materias')->insert([
            'nombre' => 'Familiar',
        ]);
        DB::table('materias')->insert([
            'nombre' => 'Mercantil',
        ]);
        DB::table('materias')->insert([
            'nombre' => 'Oralidad Familiar',
        ]);
    }
}
