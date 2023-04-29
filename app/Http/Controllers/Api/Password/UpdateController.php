<?php

namespace App\Http\Controllers\Api\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(PasswordRequest $request): JsonResponse
    {
        $request->user()->update(['password' => Hash::make($request->new_password)]);

        return response()->json();
    }
}
