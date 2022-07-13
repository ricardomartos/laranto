<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Create product test.
     *
     * @return void
     */
    public function test_create_product()
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

        $this->json('POST', 'api/products',
            [
                'name' => 'test of product',
                'description' => 'description test for product',
                'sku' => '000009867',
                'in_stock' => 0,
                'price' => 999
            ],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'description',
                    'sku',
                    'in_stock',
                    'price',
                    'created_at',
                    'id',
                    'tags'
                ]
            ])
            ->assertJson([
                "status" => true,
                "message" => "Created"
            ]);
    }

    public function test_update_product()
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

        $product = Product::latest()->first();

        $this->json('PUT', 'api/products/'.$product->id,
            [
                'name' => 'test of product edited',
                'description' => 'description test for product edited',
                'sku' => '000009860',
                'in_stock' => 1,
                'price' => 800
            ],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'description',
                    'sku',
                    'in_stock',
                    'price',
                    'created_at',
                    'id',
                    'tags'
                ]
            ])
            ->assertJson([
                "status" => true,
                "message" => "Updated"
            ]);
    }

    public function test_index_product()
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

        $this->json('GET', 'api/products',[],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'description',
                        'sku',
                        'in_stock',
                        'price',
                        'created_at',
                        'id',
                        'tags'
                    ]
                ]
            ])
            ->assertJson([
                "status" => true,
                "message" => "Product list"
            ]);
    }

    public function test_stock_product()
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

        $this->json('GET', 'api/products/stock',[],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'description',
                        'sku',
                        'in_stock',
                        'price',
                        'created_at',
                        'id',
                        'tags'
                    ]
                ]
            ])
            ->assertJson([
                "status" => true,
                "message" => "Products in stock"
            ]);
    }

    public function test_show_product()
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

        $this->json('GET', 'api/products/stock',[],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'description',
                        'sku',
                        'in_stock',
                        'price',
                        'created_at',
                        'id',
                        'tags'
                    ]
                ]
            ])
            ->assertJson([
                "status" => true,
                "message" => "Products in stock"
            ]);
    }

    public function test_destroy_product()
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

        $product = Product::latest()->first();

        $this->json('DELETE', 'api/products/'.$product->id,
            [
                'name' => 'test of product edited',
                'description' => 'description test for product edited',
                'sku' => '000009860',
                'in_stock' => 1,
                'price' => 800
            ],
            ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => 'data'
            ])
            ->assertJson([
                "status" => true,
                "message" => "Deleted"
            ]);
    }
}
