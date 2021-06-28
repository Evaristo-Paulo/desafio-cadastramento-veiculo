<?php

use App\Models\Cmodel;
use App\Models\Modelo;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modelo::create([
            'name' => 'CRF450RX',
            'slug' => 'crf450rx',
            'type_id' => 1
        ]);
        Modelo::create([
            'name' => 'California',
            'slug' => 'california',
            'type_id' => 2
        ]);
        Modelo::create([
            'name' => 'F599 GTO',
            'slug' => 'f599-gto',
            'type_id' => 2
        ]);
        Modelo::create([
            'name' => 'HR-V',
            'slug' => 'hr-v',
            'type_id' => 3
        ]);
    }
}
