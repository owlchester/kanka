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
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MapGroupController extends Controller
{
    use BulkControllerTrait;

    /**
     * Index
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $options = ['campaign' => $campaign->id, 'map' => $map->id];
        $model = $map;

        Datagrid::layout(\App\Renderers\Layouts\Map\Group::class)
            ->route('maps.map_groups.index', $options);
        $rows = $map
            ->groups()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->datagridAjax($rows);
        }

        return view('maps.groups.index', compact('campaign', 'rows', 'model'));
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()->to($map->getLink());
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
                ->route('maps.map_groups.edit', ['campaign' => $campaign->id, 'map' => $map->id, $new])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('maps.map_groups.create', ['campaign' => $campaign->id, 'map' => $map->id])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', ['campaign' => $campaign->id, $map->id])
                ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
        }

        return redirect()
            ->route('maps.map_groups.index', ['campaign' => $campaign->id, $map->id])
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
            compact('campaign', 'map', 'model')
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
                ->route('maps.map_groups.edit', ['campaign' => $campaign->id, 'map' => $map->id, $mapGroup])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('maps.map_groups.create', ['campaign' => $campaign->id, 'map' => $map->id])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', ['campaign' => $campaign->id, $map->id])
                ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
        }

        return redirect()
            ->route('maps.map_groups.index', ['campaign' => $campaign->id, $map->id])
            ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
    }

    /**
     */
    public function destroy(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $mapGroup->delete();

        return redirect()
            ->route('maps.map_groups.index', ['campaign' => $campaign->id, $map->id])
            ->withSuccess(__('maps/groups.delete.success', ['name' => $mapGroup->name]));
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
            return $this->bulkBatch($campaign, route('maps.groups.bulk', ['campaign' => $campaign, 'map' => $map]), '_map-group', $models);
        }

        $count = $this->bulkProcess($request, MapGroup::class);

        return redirect()
            ->route('maps.map_groups.index', [$campaign->id, $map->id])
            ->with('success', trans_choice('maps/groups.bulks.' . $action, $count, ['count' => $count]))
        ;
    }

    /**
     * Controls drag and drop reordering of map groups
     * @param Request $request
     * @param Map $map
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
            $group->update();
            $order++;
        }
        $order--;
        return redirect()
            ->route('maps.map_groups.index', [$campaign->id, $map->id])
            ->with('success', trans_choice('maps/groups.reorder.success', $order, ['count' => $order]));
    }
}
