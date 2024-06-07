<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Http\Resources\PostResource as Resource;
use App\Http\Requests\RecoverPost as Request;
use App\Services\RecoveryService;

class PostRecoveryApiController extends ApiController
{
    protected RecoveryService $service;

    public function __construct(RecoveryService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);
        return Resource::collection($campaign
            ->posts()->onlyTrashed()
            ->paginate());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function recover(Request $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        if (!$campaign->boosted()) {
            return response()->json(null, 204);
        }
        $this->service->recoverPosts($request->posts);

        return response()->json(['success' => 'Succesfully recovered deleted posts']);
    }
}
