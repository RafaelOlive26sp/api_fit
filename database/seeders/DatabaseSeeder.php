<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

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

        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
            'name' => Random::generate(10),
            'email' => Random::generate(10) . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            ]);
        }
    }
}
