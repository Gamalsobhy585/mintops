<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use App\Models\RecentlyVisitedCategory;


class CategoryService
{
    public function getCategories(int $page)
    {
        return Cache::remember("categories_page_{$page}", 3600, function () use ($page) {
            return Category::orderBy('name')->paginate(10); 
        });
    }
    public function logRecentlyVisitedCategory($userId, $categoryId)
{
    RecentlyVisitedCategory::updateOrCreate(
        ['user_id' => $userId, 'category_id' => $categoryId],
        ['updated_at' => now()]
    );
}

public function getRecentlyVisitedCategories($userId)
{
    return RecentlyVisitedCategory::with('category')
        ->where('user_id', $userId)
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get()
        ->pluck('category');
}
}
