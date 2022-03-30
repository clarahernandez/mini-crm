<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        $reponse = [
            'user' => $user,
            'auth_token' => $token
        ];
        return response($reponse, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully!'
        ];
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        //Check email
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'Check out your email or password!'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $reponse = [
            'user' => $user,
            'auth_token' => $token
        ];
        return response($reponse, 201);
    }
}
