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
       $this->call(UserSeeder::class);
       $this->call(TypeSeeder::class);
       $this->call(ModelSeeder::class);
       $this->call(BrandSeeder::class);
       $this->call(VersionSeeder::class);
       $this->call(TipSeeder::class);
       $this->call(TipVersionSeeder::class);
    }
}
