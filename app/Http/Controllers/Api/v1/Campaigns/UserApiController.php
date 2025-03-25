<?php

namespace App\Http\Controllers\Api\v1\Campaigns;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\API\UpdateUserRole;
use App\Http\Resources\UserResource;
use App\Models\Campaign;
use App\Models\User;
use App\Services\Campaign\MemberService;

class UserApiController extends ApiController
{
    protected MemberService $service;

    public function __construct(MemberService $memberService)
    {
        $this->service = $memberService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);

        return UserResource::collection($campaign->users()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    public function show(Campaign $campaign, User $user)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);

        return UserResource::collection($campaign->users()->where('user_id', '=', $user->id)
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * Add a single user to a role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(UpdateUserRole $request, Campaign $campaign)
    {
        $result = $this->service
            ->fromRequest($request)
            ->campaign($campaign)
            ->add();

        if ($result) {
            return response()->json([
                'data' => 'role successfully added to user',
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }

    /**
     * Remove a role from a user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(UpdateUserRole $request, Campaign $campaign)
    {
        $result = $this->service
            ->fromRequest($request)
            ->campaign($campaign)
            ->remove();

        if ($result) {
            return response()->json([
                'data' => 'role successfully removed from the user',
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }
}
