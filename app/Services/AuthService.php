<?php

namespace App\Services;

use App\Helpers\AuthHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param string $name
     * @param string $email
     * @param string $hashedPassword
     * @return array
     */
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

    /**
     * @return void
     */
    public function deleteTokens(): void
    {
        auth()->user()->tokens()->delete();
    }

    /**
     * @param User $user
     * @return string
     */
    public function createToken(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

}
