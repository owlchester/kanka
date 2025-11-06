<?php

namespace App\Http\Controllers\Whiteboards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whiteboards\UpdateRequest;
use App\Models\Campaign;
use App\Models\Whiteboard;
use App\Services\Whiteboards\ApiService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class DrawController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected ApiService $apiService) {}

    public function show(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->campaign($campaign)->authEntityView($whiteboard->entity);

        return view('whiteboards.draw', compact('campaign', 'whiteboard'));
    }

    public function api(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->campaign($campaign)->authEntityView($whiteboard->entity);

        return response()->json(
            $this->apiService->campaign($campaign)->whiteboard($whiteboard)->load()
        );
    }

    public function save(UpdateRequest $request, Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('update', $whiteboard->entity);

        $whiteboard->update($request->only('data'));

        return response()->json([
            'success' => true,
            'toast' => __('whiteboards.update.success', ['name' => $whiteboard->name]),
        ]);
    }
}
