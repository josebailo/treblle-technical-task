<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    public function __invoke(ProfileRequest $request): JsonResponse
    {
        $request->user()->update($request->validated());

        return response()->json();
    }
}
