<?php

namespace App\Http\Controllers\Maps;

use App\Facades\FormCopy;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapMarker;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class MarkerController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    /**
     * @var array fields from the input sent to the model
     */
    protected $fields = [
        'entity_id', 'name', 'entry', 'longitude', 'latitude',
        'colour', 'font_colour', 'opacity',
        'shape_id',
        'type_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'visibility_id',
        'is_draggable',
        'group_id',
        'pin_size',
        'circle_radius', 'polygon_style',
        'is_popupless',
    ];

    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $options = ['campaign' => $campaign, 'map' => $map->id];

        Datagrid::layout(\App\Renderers\Layouts\Map\Marker::class)
            ->route('maps.map_markers.index', $options);
        $this->rows = $map
            ->markers()
            ->sort(request()->only(['o', 'k']), ['id' => 'desc'])
            ->with(['map'])
            ->paginate(config('limits.pagination'));
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('maps.markers.index', $map);
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()
            ->route('entities.show', [$campaign, $map->entity]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $source = null;
        if (request()->has('source')) {
            $source = MapMarker::findOrFail(request()->get('source'));
            FormCopy::source($source);
        }

        $activeTab = 1;
        if ($source) {
            $activeTab = $source->shape_id;
        }

        return view(
            'maps.markers.create',
            compact('campaign', 'map', 'source', 'activeTab')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Map $map, StoreMapMarker $request)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model = new MapMarker();
        $data = $request->only($this->fields);
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        if ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map, 'focus' => $new->id])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', [$campaign, $map, $new])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->get('from') == 'explore') {
            return redirect()
                ->route('maps.explore', [$campaign, $map, 'focus' => $new->id]);
        }

        return redirect()
            ->route('maps.map_markers.index', [$campaign, $map, 'focus' => $new->id])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Map $map, MapMarker $mapMarker, string $from = '')
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $from = request()->get('from');
        $model = $mapMarker;
        $includeMap = true;
        $activeTab = $mapMarker->shape_id;

        return view(
            'maps.markers.edit',
            compact('map', 'campaign', 'model', 'includeMap', 'activeTab', 'from')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapMarker $request, Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fields);
        if (!request()->has('entity_id') && !isset($data['entity_id'])) {
            $data['entity_id'] = null;
        }
        $mapMarker->update($data);

        if ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map, 'focus' => $mapMarker->id])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', [$campaign, $map, $mapMarker])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        } elseif ($request->get('from') == 'explore') {
            return redirect()
                ->route('maps.explore', [$campaign, $map, 'focus' => $mapMarker->id]);
        }
        return redirect()
            ->route('maps.map_markers.index', [$campaign, $map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $mapMarker->delete();

        if (request()->get('from') == 'explore') {
            return redirect()
                ->route('maps.explore', [$campaign, $map]);
        }

        return redirect()
            ->route('maps.map_markers.index', [$campaign, $map])
            ->withSuccess(__('maps/markers.delete.success', ['name' => $mapMarker->name]));
    }
}
