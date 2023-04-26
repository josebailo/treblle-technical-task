<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($data);

        return redirect()->route('profile');
    }
}
