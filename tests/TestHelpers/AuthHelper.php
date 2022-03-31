<?php

namespace Tests\TestHelpers;

use App\Models\User;

class AuthHelper
{
    /**
     * @return string
     */
    static public function createToken(): string
    {
        $user = User::factory()->create();
        return $user->createToken('auth_token')->plainTextToken;
    }
}
