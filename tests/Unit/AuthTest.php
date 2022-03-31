<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestHelpers\AuthHelper;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_failed()
    {
        $user = User::factory()->create();

        $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->postJson('/api/auth/login', [
                'email' => $user->email,
                'password' => $user->password . '1'
            ])
            ->assertStatus(401);
    }


    public function test_logout_success()
    {
        $token = AuthHelper::createToken();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/auth/logout', []);

        $response
            ->assertOk()
            ->assertJsonFragment(['message' => 'Logged out successfully!']);
    }

    public function test_registration_fail()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('api/auth/register', [
            'name' => 'Jennifer',
            'email' => 'jennifer@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password1'
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Test registration success and the auth_token is in the response
     */
    public function test_registration()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->postJson('api/auth/register', [
            'name' => 'Jennifer',
            'email' => 'jennifer@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['user', 'auth_token']);
    }
}
