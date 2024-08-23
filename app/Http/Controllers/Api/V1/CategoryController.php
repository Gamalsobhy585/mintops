<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getCategories($request->input('page', 1));
        return new CategoryCollection($categories);
    }
    public function recentlyVisited()
{
    $userId = auth()->id();
    $categories = $this->categoryService->getRecentlyVisitedCategories($userId);

    return response()->json(['data' => $categories]);
}
public function show($id)
{
    $category = Category::findOrFail($id);
    
    $this->categoryService->logRecentlyVisitedCategory(auth()->id(), $category->id);

    return response()->json(['data' => $category]);
}
}
