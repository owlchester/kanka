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

        $models = Whiteboard::orderBy('name')->paginate();
        return view('whiteboards.index', compact('models', 'campaign'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        return view('whiteboards.create', compact('campaign'));
    }

    public function store(CreateRequest $request, Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $whiteboard = new Whiteboard($request->only('name', 'data'));
        $whiteboard->campaign_id = $campaign->id;
        $whiteboard->save();

        return response()->json([
            'success' => true,
            'id' => $whiteboard->id,
            'toast' => __('whiteboards.create.success')
        ]);
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

        return response()->json(['success' => true]);
    }
}
