<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntityAbility;
use App\Models\Ability;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Services\Entity\AbilityService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

        $translations = [
            'all' => __('crud.visibilities.all'),
            'members' => __('crud.visibilities.members'),
            'admin-self' => __('crud.visibilities.admin-self'),
            'admin' => __('crud.visibilities.admin'),
            'self' => __('crud.visibilities.self'),
            'update' => __('crud.update'),
            'remove' => __('crud.remove'),
        ];
        $translations = json_encode($translations);

        return view('entities.pages.abilities.index', compact(
            'entity',
            'translations'
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

        $data = $request->only(['abilities', 'ability_id', 'visibility']);
        $data['entity_id'] = $entity->id;

        /** @var EntityAbility $entityAbility */
        $success = '';
        if (is_array($data['abilities'])) {
            $abilities = [];
            foreach ($data['abilities'] as $abilityId) {
                $ability = Ability::find($abilityId);
                if ($ability) {
                    $entityAbility = EntityAbility::create([
                        'entity_id' => $entity->id,
                        'ability_id' => $abilityId,
                        'visibility' => $data['visibility'],
                    ]);
                    $abilities[] = $ability->name;
                }
            }
            $success = trans('entities/abilities.create.success_multiple', [
                'abilities' => implode(', ', $abilities),
                'entity' => $entity->name
            ]);
        } elseif (!empty($data['ability_id'])) {
            // Allow adding a single ability through the API
            $entityAbility = new EntityAbility();
            unset($data['abilities']);
            $entityAbility = $entityAbility->create($data);

            $success = trans('entities/abilities.create.success', [
                'ability' => $entityAbility->ability->name,
                'entity' => $entity->name
            ]);
        }

        return redirect()
            ->route('entities.entity_abilities.index', $entity)
            ->with('success', $success);
    }

    /**
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Entity $entity, EntityAbility $entityAbility)
    {
        return redirect()
            ->route('entities.entity_abilities.index', [$entity->id]);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity->child);
        $ability = $entityAbility;
        $ajax = request()->ajax();

        return view('entities.pages.abilities.update', compact(
            'entity',
            'ability',
            'ajax'
        ));
    }

    /**
     * @param StoreEntityAbility $request
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreEntityAbility $request, Entity $entity, EntityAbility $entityAbility)
    {
        $this->authorize('update', $entity->child);

        $data = $request->only(['ability_id', 'visibility', 'note', 'position']);

        $entityAbility->update($data);

        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()
            ->route('entities.entity_abilities.index', $entity->id);
    }

    /**
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

    /**
     * @param Request $request
     * @param Entity $entity
     * @param EntityAbility $entityAbility
     * @return \Illuminate\Http\JsonResponse
     */
    public function useCharge(Request $request, Entity $entity, EntityAbility $entityAbility)
    {
        return response()->json([
            'success' => $this->service
                ->entity($entity)
                ->useCharge($entityAbility, $request->post('used'))
        ]);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetCharges(Entity $entity)
    {
        $this->service
            ->entity($entity)
            ->resetCharges();

        return redirect()->route('entities.entity_abilities.index', $entity);
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function import(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        try {
            $count = $this->service
                ->entity($entity)
                ->import();

            return redirect()->route('entities.entity_abilities.index', $entity)
                ->with('success', trans_choice('entities/abilities.import.success', $count, ['count' => $count]));
        } catch (\Exception $e) {
            return redirect()->route('entities.entity_abilities.index', $entity)
                ->with('error', __('entities/abilities.import.errors.' . $e->getMessage()));
        }
    }
}
