<?php


namespace App\Http\Controllers\Maps;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapMarker;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Http\Request;

class MapMarkerController extends Controller
{
    /**
     * @var array fields from the input sent to the model
     */
    protected $fields = [
        'entity_id', 'name', 'entry', 'longitude', 'latitude',
        'colour', 'font_colour', 'opacity',
        'shape_id',
        'type_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'visibility',
        'is_draggable',
        'group_id',
    ];

    /**
     * @param Map $map
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Map $map)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();

        return view(
            'maps.markers.create',
            compact('map', 'ajax')
        );
    }

    /**
     * @param Map $map
     * @param StoreMapMarker $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Map $map, StoreMapMarker $request)
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

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));

    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();
        $model = $mapMarker;
        $includeMap = true;

        return view(
            'maps.markers.edit',
            compact('map', 'ajax', 'model', 'includeMap')
        );
    }

    /**
     * @param StoreMapMarker $request
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapMarker $request, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $mapMarker->update($request->only($this->fields));

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));

    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $mapMarker->delete();

        if (request()->get('from') == 'map') {
            return redirect()
                ->route('maps.explore', $map);
        }

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.delete.success', ['name' => $mapMarker->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function details(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('view', $map);
        if ($mapMarker->entity_id) {
            $this->authorize('view', $mapMarker->entity->child);
        }

        return response()->json([
            'body' => view('maps.markers.details', ['marker' => $mapMarker])->render(),
            'name' => $mapMarker->name
        ]);
    }

    /**
     * @param Request $request
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(Request $request, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $mapMarker->update($request->only('latitude', 'longitude'));

        return response()->json([
            'success' => true,
            'marker_id' => $mapMarker->id
        ]);
    }
}
