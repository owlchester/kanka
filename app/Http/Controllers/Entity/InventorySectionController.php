<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Inventory;
use App\Traits\GuestAuthTrait;

class InventorySectionController extends Controller
{
    use GuestAuthTrait;

    /**
     */
    public function delete(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity);
        if ($inventory->position) {
            Inventory::where('entity_id', $entity->id)->where('position', $inventory->position)->delete();
        } else {
            Inventory::where('entity_id', $entity->id)->where('position', '')->delete();
        }

        return redirect()
            ->route('entities.inventory', [$campaign, $entity])
            ->with('success_raw', __('entities/inventories.destroy.success_position', [
                'position' => $inventory->position,
                'entity' => $entity->name
            ]));
    }
}
