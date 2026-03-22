<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\TransformEntity as Request;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use App\Services\Entity\TransformService;
use Illuminate\Auth\Access\AuthorizationException;

class EntityTransformApiController extends ApiController
{
    protected TransformService $service;

    public function __construct(
        EntitySaveService $entitySaveService,
        EntityRelationsServiceFactory $relationsFactory,
        TransformService $service,
    ) {
        parent::__construct($entitySaveService, $relationsFactory);
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @throws AuthorizationException
     */
    public function transform(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $count = 0;

        $entityType = EntityType::inCampaign($campaign)->where('id', $request->entity_type)->first();
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
