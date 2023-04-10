<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JuzgadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Primero Especializado en Materia Civil',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Segundo Especializado en Materia Civil',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Tercero Especializado en Materia Civil',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Cuarto Especializado en Materia Civil',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Quinto Especializado en Materia Civil',
            'materia_id' => 1,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Sexto Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Septimo Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Octavo Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Noveno Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Décimo Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Décimo Primero Especializado en Materia Mercantil',
            'materia_id' => 3,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Primero de lo Familiar',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Segundo de lo Familiar',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Tercero de lo Familiar',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Cuarto de lo Familiar',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Quinto de lo Familiar',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Sexto de lo Familiar',
            'materia_id' => 2,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado de Primera Instancia de Oralidad Familiar',
            'materia_id' => 4,
        ]);
    }
}
