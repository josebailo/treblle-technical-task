<?php

namespace App\Http\Controllers\Api\SignIn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DestroyController extends Controller
{
    public function __invoke(): Response
    {
        Auth::guard('web')->logout();

        return response()->noContent();
    }
}
