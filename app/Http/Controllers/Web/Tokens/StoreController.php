<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTokenRequest;
use App\Services\TokenService;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __construct(public TokenService $tokenService) { }

    public function __invoke(StoreTokenRequest $request): RedirectResponse
    {
        $newToken = $this->tokenService->createNewTokenForUser($request->name, $request->user());

        return redirect()->route('tokens')
            ->with('success', __('app.token_created'))
            ->with('newToken', $newToken->plainTextToken);
    }
}
