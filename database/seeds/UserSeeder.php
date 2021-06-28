<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Evaristo Paulo',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        User::create([
            'name' => 'User Test',
            'email' => 'user@gmail.com',
            'password' => Hash::make('1234'),
        ]);
    }
}
