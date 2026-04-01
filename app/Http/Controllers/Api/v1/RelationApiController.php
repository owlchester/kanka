<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\RelationResource as Resource;
use App\Models\Campaign;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RelationApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
