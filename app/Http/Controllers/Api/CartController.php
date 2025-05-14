<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::query()
            ->with('product')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->latest()
            ->get();

        $totalWeight = $carts->sum(function ($cart) {
            return $cart->product->weight * $cart->qty;
        });
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->qty;
        });

        return response()->json([
            'status' => true,
            'message' => 'Cart fetched successfully',
            'data' => [
                'carts' => $carts,
                'total_weight' => $totalWeight,
                'total_price' => $totalPrice,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $item = Cart::query()
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('qty', $request->qty);
        } else {
            $item = Cart::create([
                'customer_id' => auth()->guard('api')->user()->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty ?? 1,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart item added successfully',
            'data' => $item
        ]);
    }

    public function increment(Request $request)
    {
        $item = Cart::query()
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->where('product_id', $request->product_id)
            ->where('id', $request->cart_id)
            ->first();

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $item->increment('qty', 1);

        return response()->json([
            'status' => true,
            'message' => 'Cart item incremented successfully',
            'data' => $item
        ]);
    }

    public function decrement(Request $request)
    {
        $item = Cart::query()
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->where('product_id', $request->product_id)
            ->where('id', $request->cart_id)
            ->first();

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        if ($item->qty > 1) {
            $item->decrement('qty', 1);
        } else {
            $item->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart item decremented successfully',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = Cart::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cart item deleted successfully',
        ]);
    }

    public function destroyAll()
    {
        $items = Cart::query()
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'All cart items deleted successfully',
        ]);
    }
}
