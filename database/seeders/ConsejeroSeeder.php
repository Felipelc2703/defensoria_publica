<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ConsejeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('consejeros')->insert([
            'nombre' => 'Jose',
            'apellido_paterno' => 'Ruiz',
            'apellido_materno' => 'Diaz',
        ]);

        DB::table('consejeros')->insert([
            'nombre' => 'Martha',
            'apellido_paterno' => 'Nacaspaca',
            'apellido_materno' => 'Ortiz',
        ]);

        DB::table('consejeros')->insert([
            'nombre' => 'Marco',
            'apellido_paterno' => 'Jimenez',
            'apellido_materno' => 'Luna',
        ]);
    }
}
