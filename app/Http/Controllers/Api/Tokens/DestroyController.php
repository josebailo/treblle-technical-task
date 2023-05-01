<?php

namespace App\Http\Controllers\Api\Tokens;

use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken;

class DestroyController extends Controller
{
    public function __construct(public TokenService $tokenService) { }

    public function __invoke(PersonalAccessToken $token): JsonResponse
    {
        if (!$this->tokenService->checkTokenBelongsToUser($token, auth()->user())) {
            return response()->json([
                'error' => __('app.token_doesnt_exist'),
            ], 401);
        }

        $token->delete();

        return response()->json();
    }
}
