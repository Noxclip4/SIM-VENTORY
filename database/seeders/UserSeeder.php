<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@simventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@simventory.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Create additional test users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@simventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@simventory.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
    }
}
