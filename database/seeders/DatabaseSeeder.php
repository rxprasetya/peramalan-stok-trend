<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'id' => Str::uuid(),
            'name' => 'rxprasetya',
            'password' => '123123123',
            'role' => 'Admin',
        ]);
    }
}
