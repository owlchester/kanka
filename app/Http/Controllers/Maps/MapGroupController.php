<?php


namespace App\Http\Controllers\Maps;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapGroup;
use App\Models\Map;
use App\Models\MapGroup;

class MapGroupController extends Controller
{
    public function create(Map $map)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();

        return view(
            'maps.groups.create',
            compact('map', 'ajax')
        );
    }

    /**
     * @param Map $map
     * @param StoreMapGroup $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Map $map, StoreMapGroup $request)
    {
        $this->authorize('update', $map);

        $model = new MapGroup();
        $data = $request->only('name', 'position', 'entry', 'visibility', 'is_shown');
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));

    }

    public function edit(Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();
        $model = $mapGroup;

        return view(
            'maps.groups.edit',
            compact('map', 'ajax', 'model')
        );
    }

    public function update(StoreMapGroup $request, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $mapGroup->update($request->only('name', 'position', 'entry', 'visibility', 'is_shown'));

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));

    }

    public function destroy(Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $mapGroup->delete();

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.delete.success', ['name' => $mapGroup->name]));
    }
}
