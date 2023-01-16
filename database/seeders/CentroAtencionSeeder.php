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
            'telefono' => '(222) 1 69 16 76',
            'numero_cajas' => 5
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Ejecución de Sentencias',
            'direccion' => 'Carretera al batán km 2.5 Col. Lomas de San Miguel, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 107',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Asuntos Laborales',
            'direccion' => 'Calle 14 Norte no. 205, Barrio La Luz',
            'telefono' => '(222) 2 46 31 37 ext 101',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Asuntos Administrativos',
            'direccion' => 'Calle 14 Norte no. 205, Barrio La Luz',
            'telefono' => '(222) 2 46 31 37 ext 101',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Cholula',
            'direccion' => 'Calle 14 Poniente, no. 1318, Barrio San Matías Cocoyotla, San Pedro Cholula.',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Atlixco',
            'direccion' => 'Calle Revolución no. 43, Colonia el León, Atlixco, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Huejotzingo',
            'direccion' => 'Avenida de las Huertas no. 917, Planta Baja, Cuarto Barrio, Huejotzingo, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tepeaca',
            'direccion' => 'Calle Colón no. 201, Colonia Centro, Tepeaca, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Acatlán',
            'direccion' => 'Carretera Internacional Méx.Oax km 190 s/n, Barrio La Palma, Acatlán, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Alatriste',
            'direccion' => 'Carretera Libramiento Chignahuapan-Zacatlán km 4.5, Localidad Toltempan, Chignahuapan, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Chalchicomula',
            'direccion' => 'Carretera Federal el Seco Azumbilla km 28, Ciudad Serdán, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Chiautla',
            'direccion' => 'Calle 5 Norte no. 33, Barrio de Titilintzin, Chiautla de Tapia, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Huauchinango',
            'direccion' => 'Calle Morelos no. 33, Segundo Piso, Colonia Centro, Huachinango, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Matamoros',
            'direccion' => 'Carretera Atlixco Izucar de Matamoros no. 141, San Martín Alchichica, Izucar de Matamoros, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial San Juan de los Llanos',
            'direccion' => 'Avenida 5 de Mayo no. 880, Colonia Centro, Libres, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tecali',
            'direccion' => 'Avenida Rafael Cortes, Oriente no. 7, Colonia Centro, Tecali de Herrera, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tecamachalco',
            'direccion' => 'Calle 8 Sur no. 703, Colonia Centro, Tecamachalco, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tehuacán',
            'direccion' => 'Carretera Fed. Pue.-Teh. km 114, Ex Hacienda San Lorenzo Teotipilco, Tehuacán, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tepexi ',
            'direccion' => 'Carretera Cuapiaxtla-Acatlán km 43+400 s/n, Colonia Morelos, Tepexi de Rodríguez, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tetela',
            'direccion' => 'Avenida y/o Prolongación de la 7 Poniente s/n, Esquina con Carretera a Cuautempan, Tetela de Ocampo, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Teziutlán',
            'direccion' => 'Calle Bugambilias no. 7, Localidad el Encanto, Chignautla, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Tlatlauquitepec',
            'direccion' => 'Avenida Reforma no. 161 Colonia Centro, Tlatlauquitepec, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Xicotepec de Juárez',
            'direccion' => 'Avenida Zaragoza s/n Colonia Centro, Xicotepec de Juárez, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Zacapoaxtla',
            'direccion' => '16 de Septiembre Norte no. 37, Planta Baja Colonia Centro, Zacapoaxtla, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
        DB::table('centros_atencion')->insert([
            'nombre' => 'Distrito Judicial Zacatlán',
            'direccion' => 'Libramiento Carretero Tramo Zacatlán el Tejocotal no. 300, Barrio de Maquixtla, Zacatlán, Puebla',
            'telefono' => '(222) 2 46 31 37 ext 108',
            'numero_cajas' => 1
        ]);
    }
}
