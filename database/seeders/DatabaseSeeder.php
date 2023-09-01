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
            RolSeeder::class,
            TipoTramiteSeeder::class,
            TramiteSeeder::class,
            MateriaSeeder::class,
            JuzgadoSeeder::class,
            JuezSeeder::Class,
            CentroAtencionSeeder::class,
            TramiteCentroSeeder::class,
            RequisitoSeeder::class,
            RequisitoTramiteSeeder::class,
            ConsejeroSeeder::class,
            UserSeeder::class,
            NotaSeeder::class,
            
        ]);
    }
}
