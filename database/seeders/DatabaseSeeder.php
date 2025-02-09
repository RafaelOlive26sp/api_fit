<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
        'name' => 'Admin Rafael',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        ]);
        User::factory()->create([
        'name' => 'Teacher Daniela',
        'email' => 'teacher@example.com',
        'password' => bcrypt('password'),
        'role' => 'teacher',
        ]);

        User::factory()->create([
            'name' => 'Juliana',
            'email' => 'Juliana@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);
    }
}
