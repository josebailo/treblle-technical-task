<?php

namespace App\Http\Controllers\Api\Tokens;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'tokens' => auth()->user()->tokens()->get(),
        ]);
    }
}
