<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JuezSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jueces')->insert([
            'nombre' => 'José Bernardo Elfego',
            'apellido_paterno' => 'Torres',
            'apellido_materno' => 'Nolasco',
            'juzgado_id' => 1,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Cargo por Asignar',
            'apellido_paterno' => '.',
            'apellido_materno' => '',
            'juzgado_id' => 2,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Heliodoro',
            'apellido_paterno' => 'Juárez',
            'apellido_materno' => 'Fernández',
            'juzgado_id' => 3,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Cesar Iván',
            'apellido_paterno' => 'Bermúdez',
            'apellido_materno' => 'Minutti',
            'juzgado_id' => 4,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Carlos Issac',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'Nava',
            'juzgado_id' => 5,
        ]);

        DB::table('jueces')->insert([
            'nombre' => 'Luis',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Vázquez',
            'juzgado_id' => 6,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Humberto',
            'apellido_paterno' => 'Borja',
            'apellido_materno' => 'Sánchez',
            'juzgado_id' => 7,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'María Emma',
            'apellido_paterno' => 'Peralta',
            'apellido_materno' => 'Juárez',
            'juzgado_id' => 8,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'María del Rosario',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Aguilera',
            'juzgado_id' => 9,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Emma Mónica',
            'apellido_paterno' => 'Garibay',
            'apellido_materno' => 'Hernández',
            'juzgado_id' => 10,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Daniel',
            'apellido_paterno' => 'Flores',
            'apellido_materno' => 'Garrido',
            'juzgado_id' => 11,
        ]);

        DB::table('jueces')->insert([
            'nombre' => 'María Rosalba',
            'apellido_paterno' => 'Pantoja',
            'apellido_materno' => 'Vázquez',
            'juzgado_id' => 12,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Julio',
            'apellido_paterno' => 'Vargas',
            'apellido_materno' => 'Domínguez',
            'juzgado_id' => 13,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'María Belem',
            'apellido_paterno' => 'Olivares',
            'apellido_materno' => 'Lobato',
            'juzgado_id' => 14,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Amada María Teresa',
            'apellido_paterno' => 'Márquez',
            'apellido_materno' => 'Bermúdez',
            'juzgado_id' => 15,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Hugo Alejandro',
            'apellido_paterno' => 'Teutli',
            'apellido_materno' => 'Cruz',
            'juzgado_id' => 16,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'José Luis',
            'apellido_paterno' => 'Arenas',
            'apellido_materno' => 'Juárez',
            'juzgado_id' => 17,
        ]);

        DB::table('jueces')->insert([
            'nombre' => 'Minerva Nikteha',
            'apellido_paterno' => 'Mejía',
            'apellido_materno' => 'Pérez',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Olga',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'Zambrano',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Jacqueline',
            'apellido_paterno' => 'Oviedo',
            'apellido_materno' => 'Hernández',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'María Guadalupe',
            'apellido_paterno' => 'Ramos',
            'apellido_materno' => 'Cruz',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Blanca Laura',
            'apellido_paterno' => 'Ollivier',
            'apellido_materno' => 'Palacios',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Gustavo',
            'apellido_paterno' => 'Torres',
            'apellido_materno' => 'Porras',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Edna',
            'apellido_paterno' => 'Vázquez',
            'apellido_materno' => 'Pérez',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Genesis Stephani',
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Hernández',
            'juzgado_id' => 18,
        ]);
        DB::table('jueces')->insert([
            'nombre' => 'Vanessa',
            'apellido_paterno' => 'Tecua',
            'apellido_materno' => 'Vázquez',
            'juzgado_id' => 18,
        ]);
    }
}
