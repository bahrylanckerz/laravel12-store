<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['category', 'ratings.customer'])
            ->withAvg('ratings', 'rating')
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%');
            })
            ->paginate(5);

        $products->getCollection()->transform(function ($products) {
            $products->ratings_avg_rating = number_format($products->ratings_avg_rating, 1);
            return $products;
        });

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }

    public function productpopular()
    {
        $products = Product::query()
            ->with(['category', 'ratings.customer'])
            ->withAvg('ratings', 'rating')
            ->withCount(['ratings' => function ($query) {
                $query->where('rating', '>=', 4);
            }])
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%');
            })
            ->orderBy('ratings_count', 'desc')
            ->limit(5)
            ->get();

        $products->transform(function ($products) {
            $products->ratings_avg_rating = number_format($products->ratings_avg_rating, 1);
            return $products;
        });

        return response()->json([
            'status' => true,
            'message' => 'Products popular retrieved successfully',
            'data' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::query()
            ->with('category', 'ratings.customer')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->ratings_avg_rating = number_format($product->ratings_avg_rating, 1);

        return response()->json([
            'status' => true,
            'message' => 'Product detail retrieved successfully',
            'data' => $product
        ]);
    }
}
