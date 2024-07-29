<?php

namespace App\Http\Controllers\Api\v1\Entities;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Entities\SlimEntityResource;
use App\Models\Campaign;

class SlimController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $perPage = (int) max(45, min(request()->get('per_page', 45), 200));

        return SlimEntityResource::collection($campaign->entities()
            ->apiFilter(request()->all())
            ->lastSync(request()->get('lastSync'))
            ->paginate($perPage)
            ->appends(request()->except(['page', 'lastSync'])));
    }
}
