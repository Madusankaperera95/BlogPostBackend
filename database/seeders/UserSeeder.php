<?php

namespace Database\Seeders;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['commenter', 'author'];

        // Create 10 users with random roles
        User::factory()->count(10)->create();
    }
}
