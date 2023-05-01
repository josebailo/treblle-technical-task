<?php

namespace App\Http\Controllers\Web\SignIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function __invoke(SignInRequest $request): RedirectResponse
    {
        if ($request->authenticate()) {
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }
}
