<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin CHOKRI',
            'email' => 'admin@agence-voyage.tn',
            'password' => Hash::make('password'),
            'phone' => '+216 20 123 456',
            'role' => 'admin',
            'loyalty_points' => 0,
            'loyalty_level' => 'platinum',
            'country' => 'TN',
            'city' => 'Tunis',
            'newsletter_subscribed' => true,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Clients test
        User::create([
            'name' => 'Mohamed Ben Ali',
            'email' => 'mohamed@example.tn',
            'password' => Hash::make('password'),
            'phone' => '+216 98 765 432',
            'role' => 'client',
            'loyalty_points' => 2800,
            'loyalty_level' => 'gold',
            'country' => 'TN',
            'city' => 'Hammamet',
            'newsletter_subscribed' => true,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatma Trabelsi',
            'email' => 'fatma@example.tn',
            'password' => Hash::make('password'),
            'phone' => '+216 22 345 678',
            'role' => 'client',
            'loyalty_points' => 1200,
            'loyalty_level' => 'silver',
            'country' => 'TN',
            'city' => 'Sousse',
            'newsletter_subscribed' => true,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::factory()->count(10)->create();
    }
}
