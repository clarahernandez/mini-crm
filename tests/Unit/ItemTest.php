<?php

namespace Tests\Unit;

use Database\Seeders\PropertySeeder;
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
            ->assertCreated()
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

    public function test_update_properties_of_item()
    {
        $this->seed(PropertySeeder::class);

        $token = AuthHelper::createToken();

        $item = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/items', [
                'name' => 'Pizza',
                'properties' => [0 => 1, 1 => 2]
            ])
            ->getOriginalContent();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->put('/api/items/' . $item->id, [
            'name' => 'Burger',
            'properties' => [3]
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.properties', [0 => ['id' => 3, 'name' => 'sweet']]);
    }
}
