<?php

namespace App\Http\Controllers\Entity;

use App\Datagrids\Sorters\EntityEntityAbilitySorter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityAbility;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\MiscModel;
use App\Services\Entity\AbilityService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbilityController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /** @var AbilityService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param AbilityService $service
     */
    public function __construct(AbilityService $service)
    {
        $this->service = $service;
        $this->middleware('campaign.boosted');
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        return view('entities.pages.abilities.index', compact(
            'entity'
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

        return view('entities.pages.abilities.create', compact(
            'entity'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEntityAbility $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['ability_id', 'visibility']);
        $data['entity_id'] = $entity->id;

        /** @var EntityAbility $entityAbility */
        $entityAbility = new EntityAbility();
        $entityAbility = $entityAbility->create($data);

        return redirect()
            ->route('entities.entity_abilities.index', $entity)
            ->with('success', trans('entities/inventories.create.success', [
                'item' => $entityAbility->ability->name,
                'entity' => $entity->name
            ]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity->child);

        return view('entities.pages.abilities.update', compact(
            'entity',
            'entityAbility'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreEntityAbility $request, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['ability_id', 'visibility']);

        $entityAbility->update($data);

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
    }

    /**
     * @param Model $model
     * @param Model $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity->child);

        if (!$entityAbility->delete()) {
            abort(500);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\JsonResponse
     */
    public function api(Entity $entity)
    {
        return response()->json([
            'data' => $this->service->entity($entity)->abilities()
        ]);
    }
}
