<?php


namespace App\Http\Controllers\Timelines;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineEra;
use App\Models\Timeline;
use App\Models\TimelineEra;

class TimelineEraController extends Controller
{
    /** @var string[] Form fields passed on to the model */
    protected $fields = [
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
    ];

    /**
     * @param Timeline $timeline
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Timeline $timeline)
    {
        $this->authorize('update', $timeline);

        $ajax = request()->ajax();

        return view(
            'timelines.eras.create',
            compact('timeline', 'ajax')
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

        $model = new TimelineEra();
        $data = $request->only($this->fields);
        $data['timeline_id'] = $timeline->id;
        $new = $model->create($data);

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

        return view(
            'timelines.eras.edit',
            compact('timeline', 'ajax', 'model')
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

        $timelineEra->update($request->only($this->fields));

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

        return redirect()
            ->route('timelines.edit', [$timeline, '#tab_form-eras'])
            ->withSuccess(__('timelines/eras.delete.success', ['name' => $timelineEra->name]));
    }
}
