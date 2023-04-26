<?php

namespace App\Http\Controllers\Web\SignIn;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember ?? false)) {
            return redirect()->route('profile');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }
}
