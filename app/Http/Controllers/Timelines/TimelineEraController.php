<?php

namespace App\Http\Controllers\Timelines;

use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\StoreTimelineEra;
use App\Models\Timeline;
use App\Models\TimelineEra;
use Illuminate\Http\Request;

class TimelineEraController extends Controller
{
    use BulkControllerTrait;

    /** @var string[] Form fields passed on to the model */
    protected $fields = [
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
        'is_collapsed',
    ];

    public function index(Timeline $timeline)
    {
        $this->authorize('update', $timeline);

        $campaign = CampaignLocalization::getCampaign();
        $options = ['timeline' => $timeline->id];
        $model = $timeline;

        Datagrid::layout(\App\Renderers\Layouts\Timeline\Era::class)
            ->route('timelines.timeline_eras.index', $options);
        $rows = $timeline
            ->eras()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['timeline'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->datagridAjax($rows);
        }

        return view('timelines.eras.index', compact('campaign', 'rows', 'model'));
    }
    public function show(Timeline $timeline, TimelineEra $timelineEra)
    {
        return redirect()->route('timelines.show', $timeline);
    }

    /**
     * @param Timeline $timeline
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Timeline $timeline)
    {
        $this->authorize('update', $timeline);
        $campaign = CampaignLocalization::getCampaign();
        $from = request()->get('from') == 'view' ? 'view' : null;

        return view(
            'timelines.eras.create',
            compact('campaign', 'timeline', 'from')
        );
    }

    /**
     * @param Timeline $timeline
     * @param StoreTimelineEra $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Timeline $timeline, StoreTimelineEra $request)
    {
        $this->authorize('update', $timeline);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model = new TimelineEra();
        $data = $request->only($this->fields);
        $data['timeline_id'] = $timeline->id;
        $new = $model->create($data);

        if (request()->post('from') == 'view') {
            return redirect()
                ->route('timelines.show', [$timeline, '#era' . $new->id])
                ->withSuccess(__('timelines/eras.create.success', ['name' => $new->name]));
        }
        return redirect()
            ->route('timelines.timeline_eras.index', [$timeline])
            ->withSuccess(__('timelines/eras.create.success', ['name' => $new->name]));
    }

    /**
     * @param Timeline $timeline
     * @param TimelineEra $timelineEra
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline);

        $ajax = request()->ajax();
        $model = $timelineEra;
        $from = request()->get('from') == 'view' ? 'view' : null;

        return view(
            'timelines.eras.edit',
            compact('timeline', 'ajax', 'model', 'from')
        );
    }

    /**
     * @param StoreTimelineEra $request
     * @param Timeline $timeline
     * @param TimelineEra $timelineEra
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreTimelineEra $request, Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $timelineEra->update($request->only($this->fields));

        if (request()->post('from') == 'view') {
            return redirect()
                ->route('timelines.show', [$timeline, '#era' . $timelineEra->id])
                ->withSuccess(__('timelines/eras.edit.success', ['name' => $timelineEra->name]));
        }

        return redirect()
            ->route('timelines.timeline_eras.index', [$timeline])
            ->withSuccess(__('timelines/eras.edit.success', ['name' => $timelineEra->name]));
    }

    /**
     * @param Timeline $timeline
     * @param TimelineEra $timelineEra
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timeline);

        $timelineEra->delete();


        if (request()->get('from') == 'view') {
            return redirect()
                ->route('timelines.show', [$timeline])
                ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
        }

        return redirect()
            ->route('timelines.timeline_eras.index', [$timeline])
            ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
    }


    /**
     * @param Request $request
     * @param Timeline $timeline
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bulk(Request $request, Timeline $timeline)
    {
        $this->authorize('update', $timeline);
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        /*if ($action === 'edit') {
            return $this->bulkBatch(route('timelines.eras.bulk', ['timeline' => $timeline]), '_timeline-era', $models);
        }*/

        $count = $this->bulkProcess($request, TimelineEra::class);

        return redirect()
            ->route('timelines.timeline_eras.index', ['timeline' => $timeline])
            ->with('success', trans_choice('timelines/eras.bulks.' . $action, $count, ['count' => $count]))
        ;
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function datagridAjax($rows)
    {
        $html = view('layouts.datagrid._table')
            ->with('rows', $rows)
            ->render();
        $deletes = view('layouts.datagrid.delete-forms')
            ->with('models', Datagrid::deleteForms())
            ->with('params', Datagrid::getActionParams())
            ->render();

        $data = [
            'success' => true,
            'html' => $html,
            'deletes' => $deletes,
        ];

        return response()->json($data);
    }
}
