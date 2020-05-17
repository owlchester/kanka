<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Http\Request;

class SearchApiController extends ApiController
{
    /**
     * @var EntityService
     */
    protected $entity;

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
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Campaign $campaign, $search)
    {
        $this->authorize('access', $campaign);

        $term = trim($search);
        $enabledEntities = $this->entity->getEnabledEntities($campaign);
        $models = Entity::whereIn('type', $enabledEntities)->where('name', 'like', "%$term%")->limit(10)->get();

        return \App\Http\Resources\Entity::collection($models);
    }
}
