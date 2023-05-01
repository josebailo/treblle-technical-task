<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tokens', [
            'tokens' => auth()->user()->tokens()->get(),
            'newToken' => session()->get('newToken'),
        ]);
    }
}
