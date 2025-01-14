<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\TransformEntity as Request;
use App\Services\Entity\TransformService;

class EntityTransformApiController extends ApiController
{
    protected TransformService $service;

    public function __construct(TransformService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transform(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $count = 0;
        foreach ($request->entities as $id) {
            $entity = Entity::find($id);
            if ($this->authorize('update', $entity)) {
                $this->service
                    ->child($entity->child)
                    ->transform($request->entity_type);
                $count++;
            }
        }

        return response()->json(['success' => 'Succesfully transformed ' . $count . ' entities.']);
    }
}
