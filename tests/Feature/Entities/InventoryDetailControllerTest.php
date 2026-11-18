<?php

use App\Http\Controllers\Entity\Inventory\DetailController;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Inventory;
use App\Models\Item;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('forbids viewing inventory details when the linked item entity is missing', function () {
    $this->asUser()->withCampaign();

    $owner = Character::factory()->create(['campaign_id' => 1]);
    $item = new Item;
    $item->exists = true;
    $item->setRelation('entity', null);
    $inventory = new Inventory(['item_id' => 1]);
    $inventory->setRelation('item', $item);

    expect(fn () => app(DetailController::class)->index(Campaign::findOrFail(1), $owner->entity, $inventory))
        ->toThrow(HttpException::class, '', 403);
});

it('allows viewing details for a custom inventory entry', function () {
    $this->asUser()->withCampaign();

    $owner = Character::factory()->create(['campaign_id' => 1]);
    $inventory = Inventory::create([
        'entity_id' => $owner->entity->id,
        'name' => 'A custom relic',
    ]);

    $this->get(route('entities.inventory.details', [1, $owner->entity, $inventory]))
        ->assertSuccessful()
        ->assertSee('A custom relic');
});
