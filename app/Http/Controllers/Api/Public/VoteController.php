<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Models\CommunityVote;
use App\Services\Api\VoteService;

class VoteController extends Controller
{
    protected VoteService $service;

    public function __construct(VoteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $votes = CommunityVote::published()
            ->orderBy('visible_at', 'DESC')
            ->paginate();

        return VoteResource::collection($votes);
    }

    public function show(CommunityVote $communityVote)
    {
        return new VoteResource($communityVote);
    }
}
