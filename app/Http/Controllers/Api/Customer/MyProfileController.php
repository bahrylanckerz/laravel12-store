<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;

class MyProfileController extends Controller implements HasMiddleware
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
        $profile = Customer::query()
            ->where('id', auth()->guard('api')->user()->id)
            ->firstOrFail();

        return response()->json([
            'status' => true,
            'message' => 'My Profile: ' . auth()->guard('api')->user()->name,
            'data' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $profile = Customer::query()
            ->where('id', auth()->guard('api')->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:customers,email,' . $profile->id,
            'phone' => 'string|max:15',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::delete('avatar/' . $profile->image);
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('avatar', $imageName, 'public');
            $profile->image = $imageName;
        }

        if($request->filled('name')) {
            $profile->name = $request->name;
        }
        if($request->filled('email')) {
            $profile->email = $request->email;
        }
        if ($request->filled('password')) {
            $profile->password = bcrypt($request->password);
        }
        if($request->filled('phone')) {
            $profile->phone = $request->phone;
        }
        if($request->filled('address')) {
            $profile->address = $request->address;
        }
        $profile->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $profile,
        ]);
    }
}
