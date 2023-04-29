<?php

namespace App\Http\Controllers\Api\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __invoke(SignInRequest $request): JsonResponse
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
