<?php

use App\Http\Requests\StoreEvent;
use App\Models\Character;
use App\Models\Event;
use Illuminate\Routing\Route;

it('rejects an entity or its descendant as its parent through shared rules', function () {
    $this->asUser()->withCampaign();
    $entity = Event::factory()->create(['campaign_id' => 1])->entity;
    $descendant = Event::factory()->create(['campaign_id' => 1])->entity;
    $descendant->update(['parent_id' => $entity->id]);
    $request = StoreEvent::create('/', 'PATCH');
    $route = new Route('PATCH', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('entity', $entity);
    $request->setRouteResolver(fn () => $route);
    $rules = $request->rules();

    foreach ([$entity->id, $descendant->id] as $parentId) {
        expect(validator(['parent_id' => $parentId], ['parent_id' => $rules['parent_id']])->fails())->toBeTrue();
    }
});

it('accepts an unrelated entity as a parent through shared rules', function () {
    $this->asUser()->withCampaign();
    $entity = Event::factory()->create(['campaign_id' => 1])->entity;
    $parent = Event::factory()->create(['campaign_id' => 1])->entity;
    $request = StoreEvent::create('/', 'PATCH');
    $route = new Route('PATCH', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('entity', $entity);
    $request->setRouteResolver(fn () => $route);
    $rules = $request->rules();

    expect(validator(['parent_id' => $parent->id], ['parent_id' => $rules['parent_id']])->passes())->toBeTrue();
});

it('ignores parents when creating characters', function () {
    $this->asUser()->withCampaign();
    $parent = Character::factory()->create(['campaign_id' => 1])->entity;

    $response = $this->postJson('/api/1.0/campaigns/1/characters', [
        'name' => 'Not nested',
        'parent_id' => $parent->id,
    ])->assertCreated();

    $character = Character::findOrFail($response->json('data.id'));

    expect($character->entity->parent_id)->toBeNull();
});

it('ignores parents when updating characters', function (bool $web) {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $data = ['name' => 'Still not nested', 'parent_id' => $entity->id];

    if ($web) {
        $this->patch(route('entities.update', [1, $entity]), $data)->assertRedirect();
    } else {
        $this->putJson('/api/1.0/campaigns/1/characters/' . $character->id, $data)->assertSuccessful();
    }

    expect($entity->fresh()->parent_id)->toBeNull();
})->with([true, false]);
