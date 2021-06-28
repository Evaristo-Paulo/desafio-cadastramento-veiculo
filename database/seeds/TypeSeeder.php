<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Caminhão',
            'slug' => 'caminhao',
        ]);
        Type::create([
            'name' => 'Carro',
            'slug' => 'carro',
        ]);
        Type::create([
            'name' => 'Moto',
            'slug' => 'moto',
        ]);
    }
}
