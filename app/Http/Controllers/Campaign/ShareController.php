<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\CampaignVisibility;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setup(Campaign $campaign): View
    {
        $this->authorize('update', $campaign);

        return view('campaigns.share.setup', compact('campaign'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Request $request, Campaign $campaign): JsonResponse
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'campaign_visibility' => ['required', 'string', 'in:public'],
        ]);

        $campaign->update(['visibility_id' => CampaignVisibility::public->value]);

        return response()->json([
            'success' => true,
            'campaign_public' => true,
        ]);
    }
}
