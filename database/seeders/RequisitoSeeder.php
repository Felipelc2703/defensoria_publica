<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequisitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requisitos')->insert([
            'nombre' => 'Acta de matrimonio (en su caso de existir).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Acta de nacimiento de sus hijos.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Domicilio de la persona que se va a demandar (calle, número, colonia).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Constancia de estudios (para el caso que los hijos sean mayores de edad).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Nombre y domicilio de la empresa o lugar en donde trabaja el demandado (Nombre correcto de la empresa y domicilio con calle, número y colonia, etc.).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Documentos para acreditar sus ingresos o especificar sus ingresos de manera detallada del demandado si los tienen.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Documentos que acrediten bienes del demandado en su caso (inmuebles, vehiculos, etc.).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Constancia de sus gastos y necesidades de los menores (por ejemplo comida, vestido, educación, habitación, renta, luz, etc.).',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Nombre y domicilio de 2 testigos con copia de credencial de elector, (pueden ser familiares y una vez propuestos no los puede cambiar) traerlos a los testigos hasta que se les indique.',
            'tipo_tramite_id' => 1,
        ]);
        DB::table('requisitos')->insert([
            'nombre' => 'Descripción detallada de los hechos (por escritos señalando circunstancia de tiempo, modo y lugar)',
            'tipo_tramite_id' => 1,
        ]);
    }
}
