<?php

namespace App\Http\Controllers\Maps;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMapLayer;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use Illuminate\Support\Arr;

class LayerController extends Controller
{
    use CampaignAware;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $options = ['campaign' => $campaign, 'map' => $map->id];

        Datagrid::layout(\App\Renderers\Layouts\Map\Layer::class)
            ->route('maps.map_layers.index', $options);
        $this->rows = $map
            ->layers()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map', 'image'])
            ->paginate(config('limits.pagination'));
        if (request()->ajax()) {
            return $this
                ->campaign($campaign)
                ->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('maps.layers.index', $map);
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()
            ->route('entities.show', [$campaign, $map->entity]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        if ($map->layers->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._layers_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }

        return view(
            'maps.layers.create',
            compact('map', 'campaign')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Map $map, StoreMapLayer $request)
    {
        $this->authorize('update', $map->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($map->layers->count() >= $campaign->maxMapLayers()) {
            return view('maps.form._groups_max')
                ->with('campaign', $campaign)
                ->with('map', $map)
                ->with('max', Campaign::LAYER_COUNT_MAX);
        }

        $model = new MapLayer;
        $data = $request->only('name', 'position', 'entry', 'visibility_id', 'type_id', 'image_uuid');
        if (Arr::exists($data, 'position')) {
            $map->layers()->where('position', '>', $data['position'] - 1)->increment('position');
        }
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        if ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_layers.edit', [$campaign, 'map' => $map, $new])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        } elseif ($request->haS('submit-new')) {
            return redirect()
                ->route('maps.map_layers.create', [$campaign, 'map' => $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        }

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map->entity);

        // Migrate to gallery
        //        if (!empty($mapLayer->image_path)) {
        //            return view('maps.layers.migrate')
        //                ->with('campaign', $campaign)
        //                ->with('map', $map)
        //                ->with('layer', $mapLayer)
        //            ;
        //        }

        $model = $mapLayer;

        return view(
            'maps.layers.edit',
            compact('campaign', 'map', 'model')
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapLayer $request, Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $mapLayer->update($request->only('name', 'position', 'entry', 'visibility_id', 'type_id', 'image_uuid'));

        if ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_layers.edit', [$campaign, $map, $mapLayer])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        } elseif ($request->haS('submit-new')) {
            return redirect()
                ->route('maps.map_layers.create', [$campaign, $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign, $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        }

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->withSuccess(__('maps/layers.edit.success', ['name' => $mapLayer->name]));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map->entity);

        $mapLayer->delete();

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->withSuccess(__('maps/layers.delete.success', ['name' => $mapLayer->name]));
    }
}
