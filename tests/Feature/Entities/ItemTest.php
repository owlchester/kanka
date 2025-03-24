<?php

use App\Models\Item;

it('POSTS an invalid item form')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/items', [])
    ->assertStatus(422);

it('POSTS a new item')
    ->asUser()
    ->withCampaign()
    ->postJson('/api/1.0/campaigns/1/items', [
        'name' => fake()->name(),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all items')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->get('/api/1.0/campaigns/1/items')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific item')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->get('/api/1.0/campaigns/1/items/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('UPDATES a valid item')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->putJson('/api/1.0/campaigns/1/items/1', ['name' => 'Estus Flask'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Estus Flask']);

it('UPDATES a valid item without a name')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->putJson('/api/1.0/campaigns/1/items/1', ['type' => 'Magic'])
    ->assertStatus(200)
    ->assertJsonFragment(['type' => 'Magic']);

it('DELETES a item')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->delete('/api/1.0/campaigns/1/items/1')
    ->assertStatus(204);

it('DELETES an invalid item')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->delete('/api/1.0/campaigns/1/items/100')
    ->assertStatus(404);

it('can GET a item as a player')
    ->asUser()
    ->withCampaign()
    ->withItems()
    ->asPlayer()
    ->get('/api/1.0/campaigns/1/items/1')
    ->assertStatus(200);

/**
 * This example showcases building a custom function in the test to avoid polluting the TestCase file with lots of
 * on-off function calls.
 */
it('can\'t GET a private item as a player', function () {
    $this->asUser()
        ->withCampaign();

    Item::factory()
        ->count(5)
        ->create(['campaign_id' => 1, 'is_private' => true]);

    $this->asPlayer();

    $response = $this->get('/api/1.0/campaigns/1/items/1');
    expect($response->status())
        ->toBe(404);
});
