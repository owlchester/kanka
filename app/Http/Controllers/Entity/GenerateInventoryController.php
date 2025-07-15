<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateInventory;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Inventory;
use App\Models\Item;
use App\Traits\GuestAuthTrait;

class GenerateInventoryController extends Controller
{
    use GuestAuthTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        return view('entities.pages.inventory.generate', compact(
            'campaign',
            'entity',
        ));
    }

    public function store(GenerateInventory $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

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
            Inventory::where('entity_id', $entity->id)->delete();
        }

        $count = 0;
        foreach ($items as $item) {
            $inventory = new Inventory;
            $inventory = $inventory->create(['item_id' => $item->id, 'entity_id' => $entity->id]);
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
