<?php

use App\Models\Version;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Version::create([
            'name' => '1.0',
        ]);
        Version::create([
            'name' => '2.1',
        ]);
        Version::create([
            'name' => '5',
        ]);
    }
}
