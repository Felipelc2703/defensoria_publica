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
            'nombre' => 'Rosalva Elena',
            'apellido_paterno' => 'Zárate',
            'apellido_materno' => 'Herrera',
        ]);

        DB::table('consejeros')->insert([
            'nombre' => 'Vania Giovanna',
            'apellido_paterno' => 'Peñasco',
            'apellido_materno' => 'Sosa',
        ]);

        DB::table('consejeros')->insert([
            'nombre' => 'Joel',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Roldán',
        ]);

        DB::table('consejeros')->insert([
            'nombre' => 'María Teresa',
            'apellido_paterno' => 'Osorio',
            'apellido_materno' => 'Cuellar',
        ]);
    }
}
