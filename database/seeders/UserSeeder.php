<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Manager
        User::create([
            'name' => 'John Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456789',
            'role' => 'manager',
            'is_active' => true,
        ]);

        // 2. Agent
        User::create([
            'name' => 'Sarah Agent',
            'email' => 'agent@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456780',
            'role' => 'agent',
            'is_active' => true,
        ]);

        // 3. Client
        User::create([
            'name' => 'Alice Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456781',
            'role' => 'client',
            'is_active' => true,
        ]);

        // 4. Bailleur (Owner)
        User::create([
            'name' => 'Bob Owner',
            'email' => 'bailleur@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456782',
            'role' => 'bailleur',
            'is_active' => true,
        ]);

        // Extra mock users for richness
        User::create([
            'name' => 'David Agent 2',
            'email' => 'agent2@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456783',
            'role' => 'agent',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Emma Client 2',
            'email' => 'client2@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456784',
            'role' => 'client',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Charlie Owner 2',
            'email' => 'bailleur2@example.com',
            'password' => Hash::make('password'),
            'phone' => '+33123456785',
            'role' => 'bailleur',
            'is_active' => true,
        ]);
    }
}
