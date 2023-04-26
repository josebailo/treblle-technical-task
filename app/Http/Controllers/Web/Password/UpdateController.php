<?php

namespace App\Http\Controllers\Web\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|current_password',
            'new_password' => 'required|string|confirmed',
        ]);

        $request->user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('password');
    }
}
