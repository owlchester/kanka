<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\RelationResource as Resource;
use App\Models\Campaign;

class RelationApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection(
            $campaign->entityRelations()
                ->has('target')
                ->paginate()
        );
    }
}
