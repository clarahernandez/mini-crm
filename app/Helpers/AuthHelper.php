<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthHelper
{
    static public function validatePassword($user, $password): bool
    {
        if (!Hash::check($password, $user->password)) {
            return false;
        }

        return true;
    }
}
