<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderTimeline;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Services\TimelineService;

class TimelineReorderController extends Controller
{
    protected TimelineService $service;

    public function __construct(TimelineService $timelineService)
    {
        $this->service = $timelineService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('update', $timeline->entity);

        $eras = $timeline
            ->eras()
            ->with(['orderedElements', 'orderedElements.entity'])
            ->ordered()
            ->get();

        return view('timelines.reorder.index', compact(
            'campaign',
            'eras',
            'timeline',
        ));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Campaign $campaign, Timeline $timeline, ReorderTimeline $request)
    {
        $this->authorize('update', $timeline->entity);

        $this->service
            ->timeline($timeline)
            ->reorder($request);

        return redirect()
            ->route('entities.show', [$campaign, $timeline->entity])
            ->withSuccess(__('timelines.reorder.success', ['name' => $timeline->name]));
    }
}
