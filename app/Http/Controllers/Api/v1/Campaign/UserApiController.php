<?php

namespace App\Http\Controllers\Api\v1\Campaign;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\UserResource;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use Illuminate\Http\Request;

class UserApiController extends ApiController
{
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
    public function add(Request $request, Campaign $campaign)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:campaign_roles,id'
        ]);
        $userRoleInfo = $this->checkIfExists($request, $campaign);
        $user = $userRoleInfo['user'];
        $role = $userRoleInfo['role'];
        $hasRole = $userRoleInfo['hasRole'];
        if ($hasRole) {
            return response()->json(['error' => 'User already in role.']);
        }
        // If both are valid, add the user to the role
        $userRole = new CampaignRoleUser();
        $userRole->user_id = $user->id;
        $userRole->campaign_role_id = $request->post('role_id');
        $userRole->save();

        return response()->json([
            'data' => 'role succesfully added to user'
        ]);
    }

    /**
     * Remove a role from a user
     * @param Request $request
     * @param Campaign $campaign
     * @return void
     */
    public function remove(Request $request, Campaign $campaign)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:campaign_roles,id'
        ]);
        $userRoleInfo = $this->checkIfExists($request, $campaign);
        $user = $userRoleInfo['user'];
        $role = $userRoleInfo['role'];
        $hasRole = $userRoleInfo['hasRole'];
        if (!$hasRole) {
            return response()->json(['error' => 'User isnt in role.']);
        }
        // If both are valid, remove user from the role
        CampaignRoleUser::where('user_id', $user->id)
        ->where('campaign_role_id', $role->id)
        ->delete();

        return response()->json([
            'data' => 'role succesfully removed from user'
        ]);
    }
}
