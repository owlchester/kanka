<?php


namespace App\Http\Controllers\Maps;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapLayer;
use App\Models\Map;
use App\Models\MapLayer;

class MapLayerController extends Controller
{
    /**
     * No index for this, redirect to the map
     * @param Map $map
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Map $map)
    {
        return redirect()->route('maps.show', $map);
    }

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
            'maps.layers.create',
            compact('map', 'ajax')
        );
    }

    /**
     * @param Map $map
     * @param StoreMapLayer $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Map $map, StoreMapLayer $request)
    {
        $this->authorize('update', $map);

        $model = new MapLayer();
        $data = $request->only('name', 'position', 'entry', 'visibility', 'type_id');
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-layers'])
            ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));

    }

    /**
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();
        $model = $mapLayer;

        return view(
            'maps.layers.edit',
            compact('map', 'ajax', 'model')
        );
    }

    /**
     * @param StoreMapLayer $request
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapLayer $request, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        $mapLayer->update($request->only('name', 'position', 'entry', 'visibility', 'type_id'));

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-layers'])
            ->withSuccess(__('maps/layers.edit.success', ['name' => $mapLayer->name]));

    }

    /**
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        $mapLayer->delete();

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-layers'])
            ->withSuccess(__('maps/layers.delete.success', ['name' => $mapLayer->name]));
    }
}
