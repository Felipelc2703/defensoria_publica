<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequisitoTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 1,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 2,
            'tramite_id' => 1,
            'obligatorio' => true
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 3,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 4,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 5,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 6,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 7,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 8,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 9,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
        DB::table('requisito_tramite')->insert([
            'requisito_id' => 10,
            'tramite_id' => 1,
            'obligatorio' => false
        ]);
    }
}
