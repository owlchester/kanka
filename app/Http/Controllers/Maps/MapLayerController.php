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
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MapLayerController extends Controller
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

        Datagrid::layout(\App\Renderers\Layouts\Map\Layer::class)
            ->route('maps.map_layers.index', $options);
        $rows = $map
            ->layers()
            ->sort(request()->only(['o', 'k']), ['position' => 'asc'])
            ->with(['map'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->datagridAjax($rows);
        }

        return view('maps.layers.index', compact('campaign', 'rows', 'model'));
    }

    public function show(Campaign $campaign, Map $map)
    {
        return redirect()->to($map->getLink());
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
            compact('campaign', 'map')
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
                ->route('maps.map_layers.edit', ['campaign' => $campaign->id, 'map' => $map->id, $new])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        } elseif ($request->haS('submit-new')) {
            return redirect()
                ->route('maps.map_layers.create', ['campaign' => $campaign->id, 'map' => $map->id])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', [$campaign->id, $map->id])
                ->withSuccess(__('maps/layers.create.success', ['name' => $new->name]));
        }

        return redirect()
            ->route('maps.map_layers.index', [$campaign->id, $map->id])
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
                ->route('maps.map_layers.edit', ['campaign' => $campaign->id, 'map' => $map, $mapLayer])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        } elseif ($request->haS('submit-new')) {
            return redirect()
                ->route('maps.map_layers.create', ['campaign' => $campaign->id, 'map' => $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        } elseif ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', ['campaign' => $campaign->id, $map])
                ->withSuccess(__('maps/layers.create.success', ['name' => $mapLayer->name]));
        }
        return redirect()
            ->route('maps.map_layers.index', ['campaign' => $campaign->id, $map])
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
            ->route('maps.map_layers.index', [$campaign->id, $map->id])
            ->withSuccess(__('maps/layers.delete.success', ['name' => $mapLayer->name]));
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
            return $this->bulkBatch(route('maps.layers.bulk', ['campaign' => $campaign, 'map' => $map]), '_map-layer', $models);
        }

        $count = $this->bulkProcess($request, MapLayer::class);

        return redirect()
            ->route('maps.map_layers.index', [$campaign->id, $map->id])
            ->with('success', trans_choice('maps/layers.bulks.' . $action, $count, ['count' => $count]))
        ;
    }

    /**
     * Controls drag and drop reordering of map layers
     * @param Request $request
     * @param Map $map
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
            $layer->update();
            $order++;
        }
        $order--;
        return redirect()
            ->route('maps.map_layers.index', [$campaign->id, $map->id])
            ->with('success', trans_choice('maps/layers.reorder.success', $order, ['count' => $order]));
    }
}
