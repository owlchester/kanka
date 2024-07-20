<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Http\Request;

class SearchApiController extends ApiController
{
    /**
     */
    protected EntityService $entity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->entity = $entityService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Campaign $campaign, ?string $search = null)
    {
        $this->authorize('access', $campaign);

        $term = trim($search);
        $enabledEntities = $this->entity->campaign($campaign)->getEnabledEntitiesID();
        $models = Entity::whereIn('type_id', $enabledEntities)->where('name', 'like', "%{$term}%")->limit(10)->get();

        return \App\Http\Resources\Entity::collection($models);
    }
}
