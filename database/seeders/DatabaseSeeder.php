<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'email' => 'test@test.test',
            'password' => Hash::make('12345678')
        ]);
        User::factory(1)->create([
            'email' => 'test@test2.test',
            'password' => Hash::make('123456789')
        ]);
    }
}
