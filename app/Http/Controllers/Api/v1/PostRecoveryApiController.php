<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\RecoverPost as Request;
use App\Http\Resources\PostResource as Resource;
use App\Models\Campaign;
use App\Services\Posts\RecoveryService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostRecoveryApiController extends ApiController
{
    protected RecoveryService $service;

    public function __construct(RecoveryService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        return Resource::collection($campaign
            ->posts()->onlyTrashed()
            ->paginate());
    }

    /**
     * @throws AuthorizationException
     */
    public function recover(Request $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        if (! $campaign->boosted()) {
            return response()->json(null, 204);
        }
        $this->service->campaign($campaign)->user($request->user())->recover($request->posts);

        return response()->json(['success' => 'Successfully recovered deleted posts']);
    }
}
