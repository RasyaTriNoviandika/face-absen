<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();
        
        try {
            // 1. Super Admin
            $superAdmin = User::updateOrCreate(
                ['email' => 'superadmin@faceattend.com'],
                [
                    'name' => 'Super Administrator',
                    'password' => Hash::make('password'),
                    'role' => 'superadmin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            // 2. Regular Admin
            $admin = User::updateOrCreate(
                ['email' => 'admin@faceattend.com'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            // 3. Demo User (with Employee)
            $demoEmployee = Employee::updateOrCreate(
                ['nip' => 'EMP001'],
                [
                    'name' => 'Demo Karyawan',
                    'email' => 'demo.employee@faceattend.com',
                    'phone' => '081234567890',
                    'department' => 'IT',
                    'position' => 'Staff IT',
                    'is_active' => true,
                    'face_registered' => false,
                ]
            );

            $demoUser = User::updateOrCreate(
                ['email' => 'demo@faceattend.com'],
                [
                    'name' => 'Demo User',
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'employee_id' => $demoEmployee->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            DB::commit();

            $this->command->info('✓ Admin accounts created successfully!');
            $this->command->info('');
            $this->command->info('Login Credentials:');
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->info('Super Admin:');
            $this->command->info('  Email: superadmin@faceattend.com');
            $this->command->info('  Password: password');
            $this->command->info('');
            $this->command->info('Admin:');
            $this->command->info('  Email: admin@faceattend.com');
            $this->command->info('  Password: password');
            $this->command->info('');
            $this->command->info('Demo User (with Employee):');
            $this->command->info('  Email: demo@faceattend.com');
            $this->command->info('  Password: password');
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}