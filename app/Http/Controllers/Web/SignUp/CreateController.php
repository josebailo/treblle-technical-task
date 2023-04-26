<?php

namespace App\Http\Controllers\Web\SignUp;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Registration');
    }
}
