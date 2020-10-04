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

        $data = $request->only(['abilities', 'ability_id', 'visibility']);
        $data['entity_id'] = $entity->id;

        /** @var EntityAbility $entityAbility */
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetCharges(Entity $entity)
    {
        $this->service
            ->entity($entity)
            ->resetCharges();

        return redirect()->route('entities.entity_abilities.index', $entity);
    }
}
