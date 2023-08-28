<?php

namespace App\Observers;

use App\Models\Inventory;

class InventoryObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     */
    public function creating(Inventory $inventory)
    {
        $inventory->created_by = auth()->user()->id;
    }

    /**
     */
    public function saving(Inventory $inventory)
    {
        $inventory->name = $this->purify($inventory->name);
        $inventory->position = $this->purify($inventory->position);
        $inventory->description = $this->purify($inventory->description);
        if ($inventory->copy_item_entry && empty($inventory->item)) {
            $inventory->copy_item_entry = false;
        }
    }

    /**
     */
    public function saved(Inventory $inventory)
    {
        // When adding or changing an inventory to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $inventory->entity->child->touchQuietly();
    }

    /**
     */
    public function deleted(Inventory $inventory)
    {
        // When deleting an inventory, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($inventory->entity) {
            $inventory->entity->child->touchQuietly();
        }
    }
}
