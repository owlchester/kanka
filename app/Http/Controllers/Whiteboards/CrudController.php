<?php

namespace App\Http\Controllers\Whiteboards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whiteboards\CreateRequest;
use App\Http\Requests\Whiteboards\UpdateRequest;
use App\Models\Campaign;
use App\Models\Whiteboard;
use App\Services\Whiteboards\ApiService;

class CrudController extends Controller
{
    public function __construct(protected ApiService $apiService)
    {

    }
    public function index(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $models = Whiteboard::orderBy('updated_at')->paginate();
        return view('whiteboards.index', compact('models', 'campaign'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $whiteboard = new Whiteboard();
        $whiteboard->name = __('whiteboards.create.default-name');
        $whiteboard->data = [];
        $whiteboard->campaign_id = $campaign->id;
        $whiteboard->save();

        return redirect()->route('whiteboards.show', [$campaign, $whiteboard]);
    }

    public function show(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('view', $whiteboard);

        if (request()->ajax()) {
            return response()->json(
                $this->apiService->campaign($campaign)->whiteboard($whiteboard)->load()
            );
        }

        return view('whiteboards.show', compact('campaign', 'whiteboard'));
    }

    public function update(UpdateRequest $request, Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('view', $whiteboard);

        $whiteboard->update($request->only('name', 'data'));

        return response()->json([
            'success' => true,
            'toast' => __('whiteboards.update.success')
        ]);
    }
}
