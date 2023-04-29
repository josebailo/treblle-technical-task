<?php

namespace App\Http\Controllers\Api\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if ($request->authenticate()) {
            return response()->json(['user' => $request->user()]);
        }

        return response()->json([
            'errors' => [
                'email' => __('auth.failed'),
            ],
        ], 422);
    }
}
