<?php

namespace App\Http\Controllers\Timelines;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\StoreTimelineEra;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Models\TimelineEra;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use Illuminate\Http\Request;

class TimelineEraController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;
    use HasDatagrid;

    /** @var string[] Form fields passed on to the model */
    protected $fields = [
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
        'is_collapsed',
    ];

    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('update', $timeline->entity);

        $options = ['campaign' => $campaign, 'timeline' => $timeline->id];

        Datagrid::layout(\App\Renderers\Layouts\Timeline\Era::class)
            ->route('timelines.timeline_eras.index', $options);
        $this->rows = $timeline
            ->eras()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['timeline'])
            ->paginate(config('limits.pagination'));
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return view('timelines.eras.index')
            ->with('rows', $this->rows)
            ->with('campaign', $campaign)
            ->with('model', $timeline)
            ->with('entity', $timeline->entity);
    }

    public function show(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        return redirect()->to($timeline->getLink());
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('update', $timeline->entity);
        $from = request()->get('from') == 'view' ? 'view' : null;

        return view(
            'timelines.eras.create',
            compact('campaign', 'timeline', 'from')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Timeline $timeline, StoreTimelineEra $request)
    {
        $this->authorize('update', $timeline->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model = new TimelineEra;
        $data = $request->only($this->fields);
        $data['timeline_id'] = $timeline->id;
        $new = $model->create($data);

        if (request()->post('from') == 'view') {
            return redirect()
                ->route('entities.show', [$campaign, $timeline->entity, '#era' . $new->id])
                ->withSuccess(__('timelines/eras.create.success', ['name' => $new->name]));
        }

        return redirect()
            ->route('timelines.timeline_eras.index', [$campaign, $timeline])
            ->withSuccess(__('timelines/eras.create.success', ['name' => $new->name]));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline->entity);

        $model = $timelineEra;
        $from = request()->get('from') == 'view' ? 'view' : null;

        return view(
            'timelines.eras.edit',
            compact('campaign', 'timeline', 'model', 'from')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreTimelineEra $request, Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $timelineEra->update($request->only($this->fields));

        if (request()->post('from') == 'view') {
            return redirect()
                ->route('entities.show', [$campaign, $timeline->entity, '#era' . $timelineEra->id])
                ->withSuccess(__('timelines/eras.edit.success', ['name' => $timelineEra->name]));
        }

        return redirect()
            ->route('timelines.timeline_eras.index', [$campaign, $timeline])
            ->withSuccess(__('timelines/eras.edit.success', ['name' => $timelineEra->name]));
    }

    public function destroy(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline->entity);

        $timelineEra->delete();

        if (request()->get('from') == 'view') {
            return redirect()
                ->route('entities.show', [$campaign, $timeline->entity])
                ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
        }

        return redirect()
            ->route('timelines.timeline_eras.index', [$campaign, $timeline])
            ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
    }

    public function bulk(Request $request, Campaign $campaign, Timeline $timeline)
    {
        $this->authorize('update', $timeline->entity);
        $action = $request->get('action');
        $models = $request->get('model');
        if (! in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        /*if ($action === 'edit') {
            return $this->bulkBatch(route('timelines.eras.bulk', [$campaign, 'timeline' => $timeline]), '_timeline-era', $models);
        }*/

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = $this->bulkProcess($request, TimelineEra::class);

        return redirect()
            ->route('timelines.timeline_eras.index', [$campaign, 'timeline' => $timeline])
            ->with('success', trans_choice('timelines/eras.bulks.' . $action, $count, ['count' => $count]));
    }

    public function positionList(Campaign $campaign, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('view', $timeline->entity);

        if ($timeline->id != $timelineEra->timeline_id) {
            abort(404);
        }

        $new = (bool) request()->get('new');

        return response()->json([
            'positions' => $timelineEra->positionOptions(null, $new),
        ]);
    }
}
