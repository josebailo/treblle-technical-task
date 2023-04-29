<?php

namespace App\Http\Controllers\Web\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function __invoke(LoginRequest $request): RedirectResponse
    {
        if ($request->authenticate()) {
            return redirect()->route('profile');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }
}
