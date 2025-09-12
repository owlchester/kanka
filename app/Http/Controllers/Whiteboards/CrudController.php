<?php

namespace App\Http\Controllers\Whiteboards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whiteboards\CreateRequest;
use App\Http\Requests\Whiteboards\UpdateRequest;
use App\Models\Campaign;
use App\Models\Whiteboard;

class CrudController extends Controller
{
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

        return response()->json(['success' => true, 'whiteboard' => $whiteboard->id]);
    }

    public function view(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('view', $whiteboard);

        return view('whiteboards.view', compact('campaign', 'whiteboard'));
    }

    public function update(UpdateRequest $request, Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->authorize('view', $campaign);
        $this->authorize('view', $whiteboard);

        return response()->json(['success' => true]);
    }
}
