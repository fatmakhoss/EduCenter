<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
        ]);

        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Add languages
        \App\Models\Langue::create([
            'nom' => 'Français',
            'code' => 'fr',
            'description' => 'Langue française',
            'active' => true,
        ]);

        \App\Models\Langue::create([
            'nom' => 'Anglais',
            'code' => 'en',
            'description' => 'Langue anglaise',
            'active' => true,
        ]);
    }
}
