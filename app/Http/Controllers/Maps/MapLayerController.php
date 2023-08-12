<?php

namespace App\Http\Controllers\Maps;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\ReorderLayers;
use App\Http\Requests\StoreMapLayer;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MapLayerController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;
    use HasDatagrid;

    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $options = ['campaign' => $campaign, 'map' => $map->id];
        $model = $map;

        Datagrid::layout(\App\Renderers\Layouts\Map\Layer::class)
            ->route('maps.map_layers.index', $options);
        $rows = $map
            ->layers()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax($rows);
        }

        return view('maps.layers.index', compact('campaign', 'rows', 'model'));
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()->route('maps.show', [$campaign, $map]);
    }

    /**
     * @param Map $map
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

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
     * @param Map $map
     * @param StoreMapLayer $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Map $map, StoreMapLayer $request)
    {
        $this->authorize('update', $map);

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

        $model = new MapLayer();
        $data = $request->only('name', 'position', 'entry', 'visibility_id', 'type_id');
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
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        $model = $mapLayer;

        return view(
            'maps.layers.edit',
            compact('campaign', 'map', 'model')
        );
    }

    /**
     * @param StoreMapLayer $request
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapLayer $request, Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $mapLayer->update($request->only('name', 'position', 'entry', 'visibility_id', 'type_id'));

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
     * @param Map $map
     * @param MapLayer $mapLayer
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map);

        $mapLayer->delete();

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->withSuccess(__('maps/layers.delete.success', ['name' => $mapLayer->name]));
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
        $this->campaign = $campaign;
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->bulkBatch(route('maps.layers.bulk', [$campaign, 'map' => $map]), '_map-layer', $models);
        }

        $count = $this->bulkProcess($request, MapLayer::class);

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->with('success', trans_choice('maps/layers.bulks.' . $action, $count, ['count' => $count]))
        ;
    }

    /**
     * Controls drag and drop reordering of map layers
     */
    public function reorder(ReorderLayers $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $order = 1;
        $ids = $request->get('layer');
        foreach ($ids as $id) {
            $layer = MapLayer::where('id', $id)->where('map_id', $map->id)->first();
            if (empty($layer)) {
                continue;
            }
            $layer->position = $order;
            $layer->updateQuietly();
            $order++;
        }
        $order--;
        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->with('success', trans_choice('maps/layers.reorder.success', $order, ['count' => $order]));
    }
}
