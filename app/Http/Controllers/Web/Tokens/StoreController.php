<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $newToken = $request->user()->createToken($request->name);

        return redirect()->route('tokens')
            ->with('success', __('app.token_created'))
            ->with('newToken', $newToken->plainTextToken);
    }
}
