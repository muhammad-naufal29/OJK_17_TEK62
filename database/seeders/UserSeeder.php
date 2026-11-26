<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin bawaan. updateOrCreate agar aman dijalankan berulang kali.
        User::updateOrCreate(
            ['email' => 'admin@ojk17.test'],
            [
                'name'     => 'Admin OJK',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
