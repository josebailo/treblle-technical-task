<?php

namespace App\Http\Controllers\Web\Authentication;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ShowLoginController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Login');
    }
}
