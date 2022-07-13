<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TagsTest extends TestCase
{
    /**
     * Create tag test.
     *
     * @return void
     */
    public function test_create_tag()
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

        $this->json('POST', 'api/tags', ['name' => 'test of tag'], ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => 'data'
            ])
            ->assertJson([
                "status" => true,
                "message" => "Created"
            ]);
    }
}
