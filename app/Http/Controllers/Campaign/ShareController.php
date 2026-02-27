<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ShareService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function __construct(protected ShareService $shareService)
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

        $this->shareService
            ->campaign($campaign)
            ->makePublic();

        return response()->json([
            'success' => true,
            'campaign_public' => true,
        ]);
    }
}
