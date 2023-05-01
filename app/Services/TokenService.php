<?php

namespace App\Services;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class TokenService
{
    public function checkTokenBelongsToUser(PersonalAccessToken $token, User $user): bool
    {
        return $token->tokenable()->first()->id === $user->id;
    }

    public function createNewTokenForUser(string $name, User $user): NewAccessToken
    {
        return $user->createToken($name);
    }
}
