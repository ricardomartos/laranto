<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Login user test.
     *
     * @return void
     * @throws \Exception
     */
    public function test_login_user()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
            ]
            );

        $this->json('POST', 'api/user/login', ['email' => 'test@example.com' , 'password' => 'password'], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => 'data'
            ])
            ->assertJson([
                "status" => true,
                "message" => "Token"
            ]);
    }


    /**
     * Get auth user test.
     *
     * @return void
     */
    public function test_get_auth_user()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
        // delete all previous tokens
        $user->tokens()->delete();

        // gets token that need to be submitted in header
        $token = $user->createToken('token')->plainTextToken;

        $this->withHeaders([
            'Accept' => 'application/json', 'Authorization' => 'Bearer '.$token
            ])->json('GET', 'api/user')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => 'data'
            ])
            ->assertJson([
                "status" => true,
                "message" => "Authenticated user",
            ]);


    }
}
