<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mobile & Web Development'],
            ['name' => 'Startup & Entrepreneurship'],
            ['name' => 'AI & Machine Learning'],
            ['name' => 'DevOps'],
            ['name' => 'Cloud Computing'],
            ['name' => 'Social Media'],
            ['name' => 'Cyber Security']
        ];

        foreach ($categories as $category) {
            Category::factory()->create(['category' => $category['name']]);
        }
    }
}
