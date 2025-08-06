<?php

namespace App\Services\Entity;

use App\Http\Requests\GenerateInventory;
use App\Models\Inventory;
use App\Models\Item;
use App\Traits\EntityAware;

class InventoryService
{
    use EntityAware;

    public function handle(GenerateInventory $request): int
    {
        if ($request->isNotFilled('tags')) {
            $items = Item::with('entity')
                ->limit($request->get('item_amount', 1))
                ->get();
        } elseif ($request->has('tags') && $request->has('match_all') && $request['match_all'] == true) {
            // Match all tags
            $items = Item::whereHas('entity', function ($query) use ($request) {
                $query
                    ->whereHas('entityTags', function ($tagQuery) use ($request) {
                        $tagQuery->whereIn('tag_id', $request->get('tags'));
                    }, '=', count($request->get('tags'))); // requires all tags
            })
                ->limit($request->get('item_amount', 1))
                ->get();

        } else {
            // Match one tag at least
            $items = Item::whereHas('entity', function ($query) use ($request) {
                $query->whereHas('entityTags', function ($tagQuery) use ($request) {
                    $tagQuery->whereIn('tag_id', $request->get('tags'));
                });
            })
                ->limit($request->get('item_amount', 1))
                ->get();
        }

        if ($request->has('replace') && $request['replace'] == true) {
            // Replace current inventory
            Inventory::where('entity_id', $this->entity->id)->delete();
        }

        $count = 0;
        foreach ($items as $item) {
            $inventory = new Inventory();
            $inventory = $inventory->create(['item_id' => $item->id, 'entity_id' => $this->entity->id]);
            $count++;
        }

        return $count;
    }
}
