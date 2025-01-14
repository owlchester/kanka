<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Requests\TransformEntity as Request;
use App\Models\EntityType;
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

        $entityType = EntityType::inCampaign($campaign)->find($request->entity_type);
        foreach ($request->entities as $id) {
            $entity = Entity::find($id);
            if ($this->authorize('update', $entity)) {
                $this->service
                    ->entity($entity)
                    ->entityType($entityType)
                    ->transform();
                $count++;
            }
        }

        return response()->json(['success' => 'Succesfully transformed ' . $count . ' entities.']);
    }
}
