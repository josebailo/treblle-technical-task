<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Sanctum\PersonalAccessToken;

class DestroyController extends Controller
{
    public function __invoke(PersonalAccessToken $token): RedirectResponse
    {
        $tokenOwnerId = $token->tokenable()->first()->id;
        $userId = auth()->id();

        if ($tokenOwnerId !== $userId) {
            return back()->with('error', __('app.token_doesnt_exist'));
        }

        $token->delete();

        return redirect()->route('tokens')->with('success', __('app.token_deleted'));
    }
}
