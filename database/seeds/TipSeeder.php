<?php

use App\Models\Tip;
use Illuminate\Database\Seeder;

class TipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tip::create([
            'user_id' => 1,
            'modelo_id' => 1,
        ]);
        Tip::create([
            'user_id' => 2,
            'modelo_id' => 2,
        ]);
        Tip::create([
            'user_id' => 1,
            'modelo_id' => 3,
        ]);
        Tip::create([
            'user_id' => 1,
            'modelo_id' => 4,
        ]);
    }
}
