<?php

namespace App\Http\Controllers\Api\SignIn;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember ?? false)) {
            return response()->json(['user' => $request->user()]);
        }

        return response()->json([
            'errors' => [
                'email' => __('auth.failed'),
            ],
        ], 422);
    }
}
