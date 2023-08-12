<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\StoreMapGroup;
use App\Facades\Datagrid;
use App\Http\Requests\ReorderGroups;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\Controllers\HasDatagrid;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MapGroupController extends Controller
{
    use BulkControllerTrait;
    use HasDatagrid;

    /**
     * Index
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $options = ['map' => $map->id];

        Datagrid::layout(\App\Renderers\Layouts\Map\Group::class)
            ->route('maps.map_groups.index', $options);
        $this->rows = $map
            ->groups()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return view('maps.groups.index')
            ->with('rows', $this->rows)
            ->with('campaign', $campaign)
            ->with('model', $map)
        ;
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()->route('maps.show', [$campaign, $map]);
    }

    /**
     */
    public function create(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        if ($map->groups->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }

        return view(
            'maps.groups.create',
            compact('map', 'campaign')
        );
    }

    /**
     */
    public function store(Campaign $campaign, Map $map, StoreMapGroup $request)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($map->groups->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }
        $model = new MapGroup();
        $data = $request->only('name', 'position', 'entry', 'visibility_id', 'is_shown');
        if (Arr::exists($data, 'position')) {
            $map->groups()->where('position', '>', $data['position'] - 1)->increment('position');
        }
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        if ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_groups.edit', [$campaign, 'map' => $map, $new])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('maps.map_groups.create', [$campaign, 'map' => $map])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        }

        return redirect()
            ->route('maps.map_groups.index', [$campaign, $map])
            ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
    }

    /**
     */
    public function edit(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);
        $model = $mapGroup;

        return view(
            'maps.groups.edit',
            compact('map', 'model', 'campaign')
        );
    }

    /**
     */
    public function update(StoreMapGroup $request, Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $mapGroup->update($request->only('name', 'position', 'entry', 'visibility_id', 'is_shown'));

        if ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_groups.edit', [$campaign, 'map' => $map, $mapGroup])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('maps.map_groups.create', [$campaign, 'map' => $map])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        }

        return redirect()
            ->route('maps.map_groups.index', [$campaign, $map])
            ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $mapGroup->delete();

        return redirect()
            ->route('maps.map_groups.index', [$campaign, $map])
            ->withSuccess(__('maps/groups.delete.success', ['name' => $mapGroup->name]));
    }

    /**
     * @param Request $request
     * @param Map $map
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bulk(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->bulkBatch(route('maps.groups.bulk', [$campaign, 'map' => $map]), '_map-group', $models);
        }

        $count = $this->bulkProcess($request, MapGroup::class);

        return redirect()
            ->route('maps.map_groups.index', [$campaign, 'map' => $map])
            ->with('success', trans_choice('maps/groups.bulks.' . $action, $count, ['count' => $count]))
        ;
    }

    /**
     * Controls drag and drop reordering of map groups
     */
    public function reorder(ReorderGroups $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $order = 1;
        $ids = $request->get('group');
        foreach ($ids as $id) {
            $group = MapGroup::where('id', $id)->where('map_id', $map->id)->first();
            if (empty($group)) {
                continue;
            }
            $group->position = $order;
            $group->updateQuietly();
            $order++;
        }
        $order--;
        return redirect()
            ->route('maps.map_groups.index', [$campaign, 'map' => $map])
            ->with('success', trans_choice('maps/groups.reorder.success', $order, ['count' => $order]));
    }
}
