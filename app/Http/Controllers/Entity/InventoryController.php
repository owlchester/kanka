<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventory;
use App\Models\Entity;
use App\Models\Inventory;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        'visibility',
        'is_equipped',
        'copy_item_entry'
    ];

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
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

        $ajax = request()->ajax();

        $inventory = $entity
            ->inventories()
            ->with(['entity', 'item', 'item.entity'])
            ->has('item')
            ->get()
            ->sortBy(function($model, $key) {
                return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
            });

        return view('entities.pages.inventory.index', compact(
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
    public function create(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();

        return view('entities.pages.inventory.create', compact(
            'entity',
            'ajax'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInventory $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only($this->fillable);
        $ajax = $request->ajax();

        $inventory = new Inventory();
        $inventory = $inventory->create($data);

        return redirect()
            ->route('entities.inventory', $entity)
            ->with('success', __('entities/inventories.create.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        $ajax = request()->ajax();

        return view('entities.pages.inventory.update', compact(
            'entity',
            'inventory',
            'ajax'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreInventory $request, Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only($this->fillable);
        $ajax = $request->ajax();

        $inventory->update($data);
        $inventory->refresh();

        return redirect()
            ->route('entities.inventory', $entity)
            ->with('success', __('entities/inventories' . '.update.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Entity $entity, Inventory $inventory)
    {
        $this->authorize('update', $entity->child);

        $inventory->delete();

        return redirect()
            ->route('entities.inventory', [$entity->id])
            ->with('success', __('entities/inventories.destroy.success', [
                'item' => $inventory->itemName(),
                'entity' => $entity->name
            ]));
    }
}
