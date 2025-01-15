<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\CopyInventory;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;

class CopyInventoryController extends Controller
{
    use GuestAuthTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.inventory.copy', compact(
            'campaign',
            'entity',
        ));
    }

    /**
     */
    public function store(CopyInventory $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $copyFrom = Entity::where('id', $request->only('entity_id'))->first();
        $count = 0;
        foreach ($copyFrom->inventories as $old) {
            $inventory = $old->replicate(['entity_id']);
            $inventory->entity_id = $entity->id;
            $inventory->save();
            $count++;
        }

        return redirect()
            ->route('entities.inventory', [$campaign, $entity])
            ->with('success_raw', trans_choice('entities/inventories.create.success_bulk', $count, [
                'entity' => $entity->name,
                'count' => $count,
            ]));
    }

}
