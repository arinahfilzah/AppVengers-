<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if not exists
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@utm.my',
            'password' => Hash::make('adminPass123!'),
            'role' => 'admin',
            'account_status' => 'active', // Set the default status
        ]);
    }
}
