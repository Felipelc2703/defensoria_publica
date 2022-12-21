<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TipoTramiteSeeder::class,
            TramiteSeeder::class,
            CentroAtencionSeeder::class,
            TramiteCentroSeeder::class,
            RequisitoSeeder::class,
            RequisitoTramiteSeeder::class,
        ]);
    }
}
