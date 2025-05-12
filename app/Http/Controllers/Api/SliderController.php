<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $sliders = Slider::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Sliders fetched successfully',
            'data' => $sliders
        ]);
    }
}
