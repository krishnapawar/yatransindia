<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => "krishna",
            'email' => "krishna@mailinator.com",
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'remember_token' => \Str::random(10),
        ]);
    }
}
