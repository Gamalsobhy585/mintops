<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public function getCategories(int $page)
    {
        return Cache::remember("categories_page_{$page}", 3600, function () use ($page) {
            return Category::orderBy('name')->paginate(10); // Lazy loading with pagination
        });
    }
}
