<?php

namespace App\Services;

use App\Helpers\AuthHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(string $name, string $email, string $hashedPassword)
    {
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        $user->save();

        return [
            'user' => $user,
            'auth_token' => $this->createToken($user)
        ];
    }

    public function deleteTokens(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function createToken(USer $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

}
