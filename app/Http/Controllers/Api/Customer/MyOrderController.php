<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Routing\Controllers\HasMiddleware;

class MyOrderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'auth:api',
            'verified'
        ];
    }

    public function index()
    {
        $transactions = Transaction::query()
            ->with('customer')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->latest()
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'My Orders: ' . auth()->guard('api')->user()->name,
            'data' => $transactions,
        ]);
    }

    public function show($snap_token)
    {
        $transaction = Transaction::query()
            ->with('customer', 'shipping', 'transactionDetail.product')
            ->where('customer_id', auth()->guard('api')->user()->id)
            ->where('snap_token', $snap_token)
            ->firstOrFail();

        if (!$transaction) {
            return response()->json([
                'status' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transaction details',
            'data' => $transaction,
        ]);
    }
}