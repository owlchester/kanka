<?php


namespace App\Http\Controllers\Api\v1;


use App\Models\Campaign;
use App\Http\Resources\RelationResource as Resource;

class RelationApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign->entityRelations()->paginate());
    }

}
