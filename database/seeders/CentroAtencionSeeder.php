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
            'nombre' => 'Distrito judicial cholula',
            'direccion' => 'Calle 14 Poniente, No 1318, Barrio San Matías Cocoyotla, San Pedro Cholula.',
            'telefono' => '222 246 31 37 ext 108',
            'numero_cajas' => 1
        ]);
    }
}
