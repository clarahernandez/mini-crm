<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthHelper
{
    static public function validateEmailLogin($user, $password): bool
    {
        //Check email
        $user = User::where('email', $user->email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        return true;
    }
}
