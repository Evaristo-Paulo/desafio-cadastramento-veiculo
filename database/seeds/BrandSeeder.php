<?php

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Ferrari',
            'slug' => 'ferrari',
        ]);
        Brand::create([
            'name' => 'Ford',
            'slug' => 'ford',
        ]);
        Brand::create([
            'name' => 'Honda',
            'slug' => 'honda',
        ]);
        Brand::create([
            'name' => 'Jeep',
            'slug' => 'jeep',
        ]);
        
        Brand::create([
            'name' => 'Volkswagen',
            'slug' => 'volkswagen',
        ]);
    }
}
