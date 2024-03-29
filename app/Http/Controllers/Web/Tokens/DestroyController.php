<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Illuminate\Http\RedirectResponse;
use Laravel\Sanctum\PersonalAccessToken;

class DestroyController extends Controller
{
    public function __construct(public TokenService $tokenService) { }

    public function __invoke(PersonalAccessToken $token): RedirectResponse
    {
        if (!$this->tokenService->checkTokenBelongsToUser($token, auth()->user())) {
            return back()->with('error', __('app.token_doesnt_exist'));
        }

        $token->delete();

        return redirect()->route('tokens')->with('success', __('app.token_deleted'));
    }
}
