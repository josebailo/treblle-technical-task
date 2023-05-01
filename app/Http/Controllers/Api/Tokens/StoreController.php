<?php

namespace App\Http\Controllers\Api\Tokens;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTokenRequest;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __construct(public TokenService $tokenService) { }

    public function __invoke(StoreTokenRequest $request): JsonResponse
    {
        $newToken = $this->tokenService->createNewTokenForUser($request->name, $request->user());

        return response()->json([
            'success' => __('app.token_created'),
            'newToken' => $newToken->plainTextToken,
        ]);
    }
}
