<?php

namespace App\Http\Controllers\Api\v1\Campaign;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\API\UpdateUserRole;
use App\Http\Resources\UserResource;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Services\Campaign\MemberService;
use Illuminate\Http\Request;

class UserApiController extends ApiController
{
    /** @var MemberService */
    protected $service;

    public function __construct(MemberService $memberService)
    {
        $this->service = $memberService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $campaign);

        return UserResource::collection($campaign->users);
    }

    /**
     * Check if user is on campaign and if has the role
     * @param Request $request
     * @param Campaign $campaign
     * @return array
     */
    private function checkIfExists(Request $request, Campaign $campaign)
    {
        // Validate the user is in the campaign
        $user = \App\User::findOrFail($request->post('user_id'));
        if ($campaign->users()->where('user_id', $user->id)->count() !== 1) {
            abort(422);
        }

        // Validate the role is in the campaign
        $role = CampaignRole::findOrFail($request->post('role_id'));
        if ($role->campaign_id !== $campaign->id) {
            abort(422);
        }
        // Validate that the user isn't already in the role
        $hasRole = CampaignRoleUser::where('user_id', $user->id)
            ->where('campaign_role_id', $role->id)
            ->count() !== 0;

        //return $hasRole;
        return compact('hasRole', 'user', 'role');
    }

    /**
     * Add a user to a role
     * @param Request $request
     * @param Campaign $campaign
     * @return void
     */
    public function add(UpdateUserRole $request, Campaign $campaign)
    {
        $result = $this->service
            ->fromRequest($request)
            ->campaign($campaign)
            ->add();

        if ($result) {
            return response()->json([
                'data' => 'role successfully added to user'
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }

    /**
     * Remove a role from a user
     * @param Request $request
     * @param Campaign $campaign
     * @return void
     */
    public function remove(UpdateUserRole $request, Campaign $campaign)
    {
        $result = $this->service
            ->fromRequest($request)
            ->campaign($campaign)
            ->remove();

        if ($result) {
            return response()->json([
                'data' => 'role successfully removed from the user'
            ]);
        }
    }
}
