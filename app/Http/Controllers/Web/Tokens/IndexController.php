<?php

namespace App\Http\Controllers\Web\Tokens;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __invoke(): Response
    {
        $tokens = auth()->user()->tokens()->get();
        return Inertia::render('Tokens', [
            'tokens' => $tokens,
            'newToken' => session()->get('newToken'),
        ]);
    }
}
