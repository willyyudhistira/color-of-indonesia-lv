<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@coi.com',
            'password' => Hash::make('Coi2025?'), // Ganti 'password' dengan password yang aman
            'role' => 'admin',
        ]);
    }
}
