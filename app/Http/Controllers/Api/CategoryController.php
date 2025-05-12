<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ]);
    }

    public function show($slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->with(['products' => function ($query) {
                $query->orderBy('name');
            }])
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully',
            'data' => $category,
        ]);
    }
}
