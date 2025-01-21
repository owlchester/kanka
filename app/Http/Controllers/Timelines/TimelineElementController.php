<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineElement;
use App\Models\Campaign;
use App\Models\TimelineEra;
use App\Services\MultiEditingService;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Services\TimelineService;
use Illuminate\Http\Request;

class TimelineElementController extends Controller
{
    protected TimelineService $service;

    /** @var string[] Form fields passed on to the model */
    protected $fields = [
        'era_id',
        'entity_id',
        'name',
        'entry',
        'position',
        'colour',
        'date',
        'visibility_id',
        'icon',
        'is_collapsed',
        'use_entity_entry',
        'use_event_date'
    ];

    /**
     * TimelineElementController constructor.
     */
    public function __construct(TimelineService $timelineService)
    {
        $this->service = $timelineService;
    }

    public function show(Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        return redirect()->route('entities.show', [$campaign, $timeline->entity]);
    }
    public function index(Campaign $campaign, Timeline $timeline)
    {
        return redirect()->route('entities.show', [$campaign, $timeline->entity]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('update', $timeline->entity);

        $eraId = $request->get('era_id');
        $position = $request->get('position', 1);
        $era = TimelineEra::findOrFail($eraId);

        return view(
            'timelines.elements.create',
            compact('campaign', 'timeline', 'eraId', 'position', 'era')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Timeline $timeline, StoreTimelineElement $request)
    {
        $this->authorize('update', $timeline->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model = new TimelineElement();
        $data = $request->only($this->fields);
        $data['timeline_id'] = $timeline->id;
        $new = $model->create($data);
        $this->service->reorderElements($new);

        return redirect()
            ->route('entities.show', [$campaign, $timeline->entity, '#timeline-element-' . $new->id])
            ->withSuccess(__('timelines/elements.create.success', ['name' => $new->name]));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        $this->authorize('update', $timeline->entity);

        $editingUsers = null;
        $model = $timelineElement;

        if ($campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($model)->user(auth()->user())->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        return view(
            'timelines.elements.edit',
            compact('timeline', 'campaign', 'model', 'editingUsers')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreTimelineElement $request, Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        $this->authorize('update', $timeline->entity);

        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($timelineElement)
            ->user($request->user())
            ->finish();

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fields);
        if (!$request->has('entity_id')) {
            $data['entity_id'] = null;
        }

        if ($request->position == null) {
            unset($data['position']);
        }

        $timelineElement->update($data);
        if ($request->position) {
            $this->service->reorderElements($timelineElement);
        }

        return redirect()
            ->route('entities.show', [$campaign, $timeline->entity, '#timeline-element-' . $timelineElement->id])
            ->withSuccess(__('timelines/elements.edit.success', ['name' => $timelineElement->name]));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Timeline $timeline, TimelineElement $timelineElement)
    {
        $this->authorize('update', $timeline->entity);

        $timelineElement->delete();
        $this->service->reorderElements($timelineElement, true);

        return redirect()
            ->route('entities.show', [$campaign, $timeline->entity])
            ->withSuccess(__('timelines/elements.delete.success', ['name' => $timelineElement->name]));
    }
}
