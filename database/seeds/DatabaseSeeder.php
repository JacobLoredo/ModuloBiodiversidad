<?php

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
         $this->call(NombreEjemplarSeeder::class);
         $this->call(SubUnidadesSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(UserSeeder::class);
        
    }
}
