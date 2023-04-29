<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;

class CampaignSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $canReset = true;
        $campaign = CampaignLocalization::getCampaign();
        return view('campaigns.modules.index', compact('campaign'))
            ->with('canReset', $canReset);
    }


    /**
     * Toggle a module in the campaign's settings
     * @param string $module
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toggle(string $module)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('setting', $campaign);

        // Validate module
        $fillable = $campaign->setting->getFillable();
        if (empty($module) || !in_array($module, $fillable)) {
            return response()->json([
                'success' => false
            ]);
        }

        $campaign->setting->{$module} = !$campaign->setting->{$module};
        $campaign->setting->save();
        $action = $campaign->setting->{$module} ? 'enabled' : 'disabled';

        return response()->json([
            'success' => true,
            'status' => $campaign->setting->{$module},
            'toast' => __('campaigns.settings.' . $action, ['module' => __('entities.' . $module)])
        ]);
    }
}
