<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display posts for a specific category.
     */
    public function show(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'category', 'comments'])
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('posts')->get();

        return view('posts.index', compact('posts', 'categories', 'category'));
    }
}
