<?php

use App\Models\Entity;
use App\Models\Inventory;
use App\Models\Item;
use Tests\TestCase;

uses(TestCase::class);

it('returns a string for custom and linked item names', function (?string $name, bool $hasItem, ?string $itemName, string $expected) {
    $item = null;
    if ($hasItem) {
        $item = new Item;
        $item->exists = true;
        $item->setRelation('entity', $itemName === null ? null : new Entity(['name' => $itemName]));
    }

    $inventory = new Inventory(['name' => $name]);
    $inventory->setRelation('item', $item);

    expect($inventory->itemName())->toBe($expected);
})->with([
    'custom name takes precedence' => ['Custom sword', true, 'Sword', 'Custom sword'],
    'linked item name' => [null, true, 'Sword', 'Sword'],
    'empty custom name' => ['', true, 'Sword', 'Sword'],
    'linked item without an entity' => [null, true, null, ''],
    'no item or custom name' => [null, false, null, ''],
    'custom name without an item' => ['Custom sword', false, null, 'Custom sword'],
]);
