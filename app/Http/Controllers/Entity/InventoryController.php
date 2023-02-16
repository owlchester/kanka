<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventory;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Inventory;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var string */
    protected $transKey;

    /** @var string */
    protected $viewPath;

    /** @var string[]  */
    protected $fillable = [
        'amount',
        'name',
        'item_id',
        'entity_id',
        'position',
        'description',
        'visibility_id',
        'is_equipped',
        'copy_item_entry'
    ];

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }
        $campaign = CampaignLocalization::getCampaign();
        $ajax = request()->ajax();

        $inventory = $entity
            ->inventories()
            ->with(['entity', 'item', 'item.entity'])
            ->get()
            ->sortBy(function ($model, $key) {
                return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
            });

        return view('entities.pages.inventory.index', compact(
            'campaign',
            'ajax',
            'entity',
            'inventory',
        ));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.inventory.create', compact(
            'campaign',
            'entity',
        ));
    }

    /**
     */
    public function store(StoreInventory $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fillable);
        $ajax = $request->ajax();

        $inventory = new Inventory();
        $inventory = $inventory->create($data);

        return redirect()
            ->route('entities.inventory', [$campaign, $entity->id])
            ->with('success', __('entities/inventories.create.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }

    /**
     */
    public function edit(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.inventory.update', compact(
            'campaign',
            'entity',
            'inventory',
        ));
    }

    /**
     */
    public function update(StoreInventory $request, Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only($this->fillable);
        $ajax = $request->ajax();

        $inventory->update($data);
        $inventory->refresh();

        return redirect()
            ->route('entities.inventory', [$campaign, $entity->id])
            ->with('success', __('entities/inventories' . '.update.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        $inventory->delete();

        return redirect()
            ->route('entities.inventory', [$campaign, $entity->id])
            ->with('success', __('entities/inventories.destroy.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }
}
