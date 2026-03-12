<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderTimeline;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Services\TimelineService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TimelineReorderController extends Controller
{
    protected TimelineService $service;

    public function __construct(TimelineService $timelineService)
    {
        $this->service = $timelineService;
    }

    /**
     * @return Factory|View
     *
     * @throws AuthorizationException
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
     * @throws AuthorizationException
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
