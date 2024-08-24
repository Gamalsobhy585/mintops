<?php

namespace App\Services;

interface CategoryServiceInterface
{
    public function getCategories(int $page);

    public function logRecentlyVisitedCategory(int $userId, int $categoryId);

    public function getRecentlyVisitedCategories(int $userId);
}
