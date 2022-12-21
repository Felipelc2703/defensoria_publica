<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipoTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_tramites')->insert([
            'nombre' => 'Asuntos Civiles y Familiares',
        ]);
        DB::table('tipo_tramites')->insert([
            'nombre' => 'Asuntos Administrativos',
        ]);
        DB::table('tipo_tramites')->insert([
            'nombre' => 'Asuntos Laborales',
        ]);
        DB::table('tipo_tramites')->insert([
            'nombre' => 'Ejecución de Sentencias',
        ]);
    }
}
