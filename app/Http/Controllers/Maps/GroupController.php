<?php

namespace App\Http\Controllers\Maps;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapGroup;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use Illuminate\Support\Arr;

class GroupController extends Controller
{
    use CampaignAware;
    use HasDatagrid;
    use HasSubview;

    /**
     * Index
     */
    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $options = ['map' => $map->id];

        Datagrid::layout(\App\Renderers\Layouts\Map\Group::class)
            ->route('maps.map_groups.index', $options);
        $this->rows = $map
            ->groups()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map'])
            ->paginate(config('limits.pagination'));

        $groups = $map
            ->groups()
            ->orderBy('position', 'asc')
            ->with(['map'])
            ->get();

        $this->campaign($campaign);

        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return view('cruds.subview')
            ->with([
                'fullview' => 'maps.groups.index',
                'model' => $map,
                'entity' => $map->entity,
                'campaign' => $this->campaign,
                'rows' => $this->rows,
                'groups' => $groups,
                'mode' => $this->descendantsMode(),
            ]);

    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()->route('entities.show', [$campaign, $map->entity]);
    }

    public function create(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        if (! auth()->user()->can('addGroup', [$map, $campaign])) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', config('limits.campaigns.maps.groups.premium'));
        }

        return view(
            'maps.groups.create',
            compact('map', 'campaign')
        );
    }

    public function store(Campaign $campaign, Map $map, StoreMapGroup $request)
    {
        $this->authorize('update', $map->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if (! auth()->user()->can('addGroup', [$map, $campaign])) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', config('limits.campaigns.maps.groups.premium'));
        }
        $model = new MapGroup;
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

    public function edit(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map->entity);
        $model = $mapGroup;

        return view(
            'maps.groups.edit',
            compact('map', 'model', 'campaign')
        );
    }

    public function update(StoreMapGroup $request, Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map->entity);

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

    public function destroy(Campaign $campaign, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map->entity);

        $mapGroup->delete();

        return redirect()
            ->route('maps.map_groups.index', [$campaign, $map])
            ->withSuccess(__('maps/groups.delete.success', ['name' => $mapGroup->name]));
    }
}
