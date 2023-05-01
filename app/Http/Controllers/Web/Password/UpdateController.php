<?php

namespace App\Http\Controllers\Web\Password;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(PasswordRequest $request): RedirectResponse
    {
        $request->user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('password')->with('success', __('app.password_updated'));
    }
}
