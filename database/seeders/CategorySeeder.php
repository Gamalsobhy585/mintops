<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Health', 'Finance', 'Home', 'Projects', 'Social', 'Learning', 'Entertainment',
            'Shopping', 'Travel Planning', 'Self-Care', 'Events', 'Technology',
            'Community Service', 'Creative Projects', 'Maintenance', 'Pets',
            'Seasonal', 'Fitness', 'Books', 'Mindfulness', 'Legal'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
