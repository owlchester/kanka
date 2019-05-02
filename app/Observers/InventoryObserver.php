<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Services\EntityMappingService;
use Illuminate\Support\Facades\Auth;

class InventoryObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param Inventory $inventory
     */
    public function creating(Inventory $inventory)
    {
        $inventory->created_by = Auth::user()->id;
    }

    /**
     * @param Inventory $inventory
     */
    public function saving(Inventory $inventory)
    {
        $inventory->position = $this->purify($inventory->position);
        $inventory->description = $this->purify($inventory->description);
    }

    /**
     * @param Inventory $inventory
     */
    public function saved(Inventory $inventory)
    {
        // When adding or changing an inventory to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $inventory->entity->child->savingObserver = false;
        $inventory->entity->child->touch();
    }

    /**
     * @param Inventory $inventory
     */
    public function deleted(Inventory $inventory)
    {
        // When deleting an inventory, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($inventory->entity) {
            $inventory->entity->child->touch();
        }
    }
}
