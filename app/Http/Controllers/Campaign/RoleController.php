<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\EntitySetup;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRole;use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @param Request $request
     * @param CampaignRole $campaignRole
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function savePermissions(Request $request, Campaign $campaign, CampaignRole $campaignRole)
    {
        $this->authorize('update', $campaignRole);

        $campaignRole->savePermissions($request->post('permissions', []));

        return redirect()->route('campaign_roles.show', ['campaign' => $campaign, 'campaign_role' => $campaignRole])
            ->with('success', trans('crud.permissions.success'));
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function admin(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->where('is_admin', true)->firstOrFail();

        return $this->show($campaign, $adminRole);
    }

    /**
     * campaign/<id>/campaign_roles/admin fast url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function public(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        $adminRole = $campaign->roles()->public()->firstOrFail();

        return $this->show($campaign, $adminRole);
    }


    /**
     * Toggle a permission on a role
     * @param CampaignRole $campaignRole
     * @param int $entityType
     * @param int $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Campaign $campaign, CampaignRole $campaignRole, int $entityType, int $action)
    {
        $this->authorize('update', $campaignRole);

        if (!$campaignRole->is_public) {
            abort(404);
        }

        $enabled = $campaignRole->toggle($entityType, $action);
        return response()->json([
            'success' => true,
            'status' => $enabled,
            'toast' => __('campaigns/roles.toggle.' . ($enabled ? 'enabled' : 'disabled'), [
                'role' => $campaignRole->name,
                'action' => __('crud.permissions.actions.read'),
                'entities' => EntitySetup::plural($entityType)
            ]),
        ]);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request, Campaign $campaign)
    {
        $this->authorize('members', $campaign);

        $term = $request->get('q', null);
        if (empty($term)) {
            $members = $campaign->roles()->where('is_admin', 0)->where('is_public', 0)->orderBy('name', 'asc')->limit(5)->get();
        } else {
            $members = $campaign->roles()->where('is_admin', 0)->where('is_public', 0)->where('name', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $results = [];
        foreach ($members as $member) {
            $results[] = [
                'id' => $member->id,
                'text' => $member->name
            ];
        }

        return response()->json($results);
    }
}
