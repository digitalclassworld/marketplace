<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name'              => 'Super Admin',
                'phone'             => '9876543210',
                'password'          => Hash::make('Admin@123'),
                'role'              => 'superadmin',
                'email_verified_at' => now(),
            ]
        );
    }
}

