<?php


namespace App\Http\Controllers\Maps;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapMarker;
use App\Models\Map;
use App\Models\MapMarker;

class MapMarkerController extends Controller
{
    protected $fields = [
        'entity_id', 'name', 'entry', 'longitude', 'latitude', 'colour',
        'shape_id',
        'type_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'visibility'
    ];

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

        $model = new MapMarker();
        $data = $request->only($this->fields);
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));

    }

    public function edit(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();
        $model = $mapMarker;

        return view(
            'maps.markers.edit',
            compact('map', 'ajax', 'model')
        );
    }

    public function update(StoreMapMarker $request, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $mapMarker->update($request->only($this->fields));

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));

    }

    public function destroy(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $mapMarker->delete();

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.delete.success', ['name' => $mapMarker->name]));
    }
}
