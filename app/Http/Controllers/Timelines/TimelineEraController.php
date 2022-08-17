<?php


namespace App\Http\Controllers\Timelines;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineEra;
use App\Http\Requests\ReorderTimelineEras;
use App\Models\Timeline;
use App\Models\TimelineEra;
use App\Services\TimelineService;
use Illuminate\Http\Request;

class TimelineEraController extends Controller
{
    /** @var string[] Form fields passed on to the model */
    protected $fields = [
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
        'is_collapsed',
    ];

    /** @var TimelineService */
    protected $service;

    public function __construct(TimelineService $timelineService)
    {
        $this->service = $timelineService;
    }

    public function index(Timeline $timeline)
    {
        return redirect()->route('timelines.show', $timeline);
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
        $ajax = request()->ajax();
        $from = request()->get('from') == 'view' ? 'view' : null;

        return view(
            'timelines.eras.create',
            compact('timeline', 'ajax', 'from')
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
                ->route('timelines.show', [$timeline, '#' . $new->id])
                ->withSuccess(__('timelines/eras.create.success', ['name' => $new->name]));
        }
        return redirect()
            ->route('timelines.edit', [$timeline, '#tab_form-eras'])
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
                ->route('timelines.show', [$timeline, '#' . $timelineEra->id])
                ->withSuccess(__('timelines/eras.edit.success', ['name' => $timelineEra->name]));
        }

        return redirect()
            ->route('timelines.edit', [$timeline, '#tab_form-eras'])
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
            ->route('timelines.edit', [$timeline, '#tab_form-eras'])
            ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
    }

    /**
     * @param Timeline $timeline
     * @param TimelineEra $timelineEra
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reorder(Timeline $timeline, TimelineEra $timelineEra)
    {
        $this->authorize('update', $timelineEra->timeline);

        $this->service->reorderEra($timelineEra, request()->post('element_ids', []));
        return redirect()
            ->route('timelines.show', [$timeline, '#era-' . $timelineEra->id])
            ->withSuccess(__('timelines/eras.reorder.success', ['era' => $timelineEra->name]));
    }

    /**
     * @param Timeline $timeline
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reorderEras(Timeline $timeline)
    {
        $this->authorize('update', $timeline);

        $eras = $timeline->eras()->ordered()->get();

        return view('timelines.eras.reorder', compact(
            'eras',
            'timeline'
        ));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Timeline $timeline, ReorderTimelineEras $request)
    {
        $this->authorize('update', $timeline);

        $this->service
            ->reorder($request);
        return redirect()
            ->route('timelines.show', [$timeline])
            ->withSuccess(__('timelines/eras.reorder.eras_success'));
    }
}
