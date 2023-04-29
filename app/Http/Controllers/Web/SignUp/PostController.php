<?php

namespace App\Http\Controllers\Web\SignUp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function __invoke(SignUpRequest $request): RedirectResponse
    {
        $request->signUp();

        return redirect()->route('home');
    }
}
