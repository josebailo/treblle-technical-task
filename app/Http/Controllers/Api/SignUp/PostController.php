<?php

namespace App\Http\Controllers\Api\SignUp;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
        ]);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::guard('web')->login($user);

        return response()->json([
            'user' => $user,
        ]);
    }
}
