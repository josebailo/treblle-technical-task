<?php

namespace App\Http\Controllers\Api\SignUp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __invoke(SignUpRequest $request): JsonResponse
    {
        $user = $request->signUp();

        return response()->json([
            'user' => $user,
        ]);
    }
}
