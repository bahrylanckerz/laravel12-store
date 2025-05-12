<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public static function middleware()
    {
        return [
            'auth:api',
            'verified'
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $checkRating = Rating::query()
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        if ($checkRating) {
            return response()->json([
                'status' => false,
                'message' => 'You have already rated this product',
                'data' => $checkRating
            ], 422);
        }

        $rating = Rating::create([
            'transaction_detail_id' => $request->transaction_detail_id,
            'customer_id' => auth()->guard('api')->user()->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Rating created successfully',
            'data' => $rating
        ], 201);
    }
}
