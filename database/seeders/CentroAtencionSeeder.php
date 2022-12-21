<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CentroAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centros_atencion')->insert([
            'nombre' => 'Dirección Asuntos Civiles, Familiares y Administrativos (Puebla Capital)',
            'direccion' => 'Arco Sur del Periférico Ecológico 4000, Reserva Territorial Atlixcayotl San Andrés Cholula, Pue.',
            'telefono' => '22 22 22 11 11',
            'numero_cajas' => 5
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Ejecución de Sentencias',
            'direccion' => 'Carretera al batán kilómetro 2.5 colonia Lomas de San Miguel, Puebla',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Asuntos Laborales',
            'direccion' => 'Calle 14 Norte número 205, Barrio La Luz',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Asuntos Administrativos',
            'direccion' => 'Calle 14 Norte número 205, Barrio La Luz',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito judicial cholula',
            'direccion' => 'Calle 14 Poniente, No 1318, Barrio San Matías Cocoyotla, San Pedro Cholula.',
            'telefono' => '222 246 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Atlixco',
            'direccion' => 'Calle Revolución Num. 43, Colonia el León, Atlixco, Puebla',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Huejotzingo',
            'direccion' => 'Avenida de las Huertas No. 917, Planta Baja, Cuarto Barrio, Huejotzingo, Puebla',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tepeaca',
            'direccion' => 'Calle Colón No. 201, Colonia Centro, Tepeaca, Puebla',
            'telefono' => '22 11 22 11 22',
            'numero_cajas' => 1
        ]);
    }
}
