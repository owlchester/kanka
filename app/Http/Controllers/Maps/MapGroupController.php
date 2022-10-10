<?php

namespace App\Http\Controllers\Maps;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapGroup;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;

class MapGroupController extends Controller
{
    /**
     */
    public function create(Map $map)
    {
        $this->authorize('update', $map);
        $campaign = CampaignLocalization::getCampaign();

        if ($map->groups->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }

        $ajax = request()->ajax();

        return view(
            'maps.groups.create',
            compact('map', 'ajax')
        );
    }

    /**
     */
    public function store(Map $map, StoreMapGroup $request)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $campaign = CampaignLocalization::getCampaign();
        if ($map->groups->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }

        $model = new MapGroup();
        $data = $request->only('name', 'position', 'entry', 'visibility_id', 'is_shown');
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.create.success', ['name' => $new->name]));
    }

    /**
     */
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

    /**
     */
    public function update(StoreMapGroup $request, Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $mapGroup->update($request->only('name', 'position', 'entry', 'visibility_id', 'is_shown'));

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.edit.success', ['name' => $mapGroup->name]));
    }

    /**
     */
    public function destroy(Map $map, MapGroup $mapGroup)
    {
        $this->authorize('update', $map);

        $mapGroup->delete();

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-groups'])
            ->withSuccess(__('maps/groups.delete.success', ['name' => $mapGroup->name]));
    }
}
