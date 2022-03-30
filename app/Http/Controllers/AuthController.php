<?php

namespace App\Http\Controllers;


use App\Helpers\AuthHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->service->register(
            $request->input(['name']),
            $request->input(['email']),
            bcrypt($request->input(['password']))
        );

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $this->service->deleteTokens();

        return [
            'message' => 'Logged out successfully!'
        ];
    }

    public function login(LoginRequest $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $user = User::where('email', $email)->first();

        if (!AuthHelper::validateEmailLogin($user, $password)) {
            return response([
                'message' => 'Check out your email or password!'
            ], 401);
        }

        return response([
            'user' => $user,
            'auth_token' => $this->service->createToken($user)
        ], 201);
    }
}
