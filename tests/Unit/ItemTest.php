<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestHelpers\AuthHelper;

class ItemTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function test_list_items_unauthorized()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get('/api/items');

        $response->assertUnauthorized();
    }

    /**
     * @return void
     */
    public function test_list_items()
    {
        $token = AuthHelper::createToken();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->get('/api/items');

        $response->assertOk();
    }

    public function test_create_item()
    {
        $token = AuthHelper::createToken();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/items', [
               'name' => 'Pizza',
               'properties' => []
            ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'properties'
                ]
            ]);
    }


    /**
     * Update item name.
     */
    public function test_update_item()
    {
        $token = AuthHelper::createToken();

        $item = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/items', [
                'name' => 'Pizza',
                'properties' => []
            ])
            ->getOriginalContent();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->put('/api/items/' . $item->id, [
            'name' => 'Burger',
            'properties' => []
        ]);

       $response
           ->assertOk()
           ->assertJsonFragment(['name' => 'Burger'])
           ->assertJsonStructure([
               'data' => [
                   'id',
                   'name',
                   'created_at',
                   'updated_at',
                   'properties'
               ]
           ]);
    }


    /**
     * Delete one item test
     */
    public function test_delete_item()
    {
        $token = AuthHelper::createToken();

        $item = $this->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer $token"
            ])
            ->postJson('/api/items', ['name' => 'Pizza', 'properties' => []])
            ->getOriginalContent();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->delete('/api/items/' .  $item->id);

        $response->assertStatus(204);
    }

    /**
     * Delete one item doesn't exist must throw error 500.
     */
    public function test_delete_one_item_doesnt_exist()
    {
        $token = AuthHelper::createToken();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->delete('/api/items/' .  1);

        $response->assertStatus(500);
    }

    //TODO: Adding properties to one item. Need to solve seeder problem.
}
