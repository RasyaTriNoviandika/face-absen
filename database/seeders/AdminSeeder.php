<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
{
    // Create or update Super Admin
    User::updateOrCreate(
        ['email' => 'admin@faceattend.com'], // cek berdasarkan email
        [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'is_active' => true,
        ]
    );

    // Create or update Regular Admin
    User::updateOrCreate(
        ['email' => 'admin2@faceattend.com'], // cek berdasarkan email
        [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]
    );
}
}