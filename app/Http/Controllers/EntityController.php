<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEntityRequest;
use App\Http\Requests\MoveEntityRequest;
use App\Models\Entity;
use App\Services\EntityService;

class EntityController extends Controller
{
    protected $entityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
        $this->entityService = $entityService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function move(Entity $entity)
    {
        $entities = $this->entityService->labelledEntities(true, $entity->pluralType());
        return view('cruds.move', ['entity' => $entity, 'entities' => $entities]);
    }

    /**
     * @param MoveEntityRequest $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(MoveEntityRequest $request, Entity $entity)
    {
        $this->authorize('move', $entity->child);

        $entity = $this->entityService->move($entity, $request->get('target'));

        return redirect()->route($entity->pluralType() . '.show', $entity->entity_id) // can't use child->id, not new
            ->with('success', trans('crud.move.success', ['name' => $entity->name]));
    }

    public function create(CreateEntityRequest $request)
    {
        $entity = $this->entityService->create($request->post('name'), $request->post('target'));
        return response()->json([
            'id' => $entity->id,
            'name' => $entity->name
        ]);
    }
}
