<?php

use App\Models\TipVersion;
use Illuminate\Database\Seeder;

class TipVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipVersion::create([
            'tip_id' => 1,
            'version_id' => 1,
        ]);
        TipVersion::create([
            'tip_id' => 2,
            'version_id' => 3,
        ]);
        TipVersion::create([
            'tip_id' => 3,
            'version_id' => 1,
        ]);
    }
}
