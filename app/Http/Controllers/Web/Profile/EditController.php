<?php

namespace App\Http\Controllers\Web\Profile;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Profile');
    }
}
