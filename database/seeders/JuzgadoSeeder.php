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
            'prefijo_folio' => '1C',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Segundo Especializado en Materia Civil',
            'prefijo_folio' => '2C',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Tercero Especializado en Materia Civil',
            'prefijo_folio' => '3C',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Cuarto Especializado en Materia Civil',
            'prefijo_folio' => '4C',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 1,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Quinto Especializado en Materia Civil',
            'prefijo_folio' => '5C',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 1,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Sexto Especializado en Materia Mercantil',
            'prefijo_folio' => '6M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Septimo Especializado en Materia Mercantil',
            'prefijo_folio' => '7M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Octavo Especializado en Materia Mercantil',
            'prefijo_folio' => '8M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Noveno Especializado en Materia Mercantil',
            'prefijo_folio' => '9M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Décimo Especializado en Materia Mercantil',
            'prefijo_folio' => '10M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Décimo Primero Especializado en Materia Mercantil',
            'prefijo_folio' => '11M',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 3,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Primero de lo Familiar',
            'prefijo_folio' => '1F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Segundo de lo Familiar',
            'prefijo_folio' => '2F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Tercero de lo Familiar',
            'prefijo_folio' => '3F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Cuarto de lo Familiar',
            'prefijo_folio' => '4F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Quinto de lo Familiar',
            'prefijo_folio' => '5F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);
        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado Sexto de lo Familiar',
            'prefijo_folio' => '6F',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 2,
        ]);

        DB::table('juzgados')->insert([
            'nombre' => 'Juzgado de Primera Instancia de Oralidad Familiar',
            'prefijo_folio' => '1OF',
            'direccion' => 'Periférico Ecológico Arco Sur No. 4000 San Andrés Cholula, Puebla. Reserva Territorial Atlixcáyotl',
            'materia_id' => 4,
        ]);
    }
}
