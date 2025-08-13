<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateInventory;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\InventoryService;
use App\Traits\GuestAuthTrait;

class GenerateInventoryController extends Controller
{
    use GuestAuthTrait;

    public function __construct(protected InventoryService $service) {}

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

        $count = $this->service
            ->entity($entity)
            ->handle($request);

        return redirect()
            ->route('entities.inventory', [$campaign, $entity])
            ->with('success_raw', trans_choice('entities/inventories.create.success_bulk', $count, [
                'entity' => $entity->name,
                'count' => $count,
            ]));
    }
}
