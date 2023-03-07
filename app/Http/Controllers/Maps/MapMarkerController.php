<?php

namespace App\Http\Controllers\Maps;

use App\Facades\FormCopy;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\StoreMapMarker;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;

class MapMarkerController extends Controller
{
    use BulkControllerTrait;
    /**
     * Auth for guests with model
     */
    use GuestAuthTrait;

    protected $model = Map::class;

    /**
     * @var array fields from the input sent to the model
     */
    protected $fields = [
        'entity_id', 'name', 'entry', 'longitude', 'latitude',
        'colour', 'font_colour', 'opacity',
        'shape_id',
        'type_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'visibility_id',
        'is_draggable',
        'group_id',
        'pin_size',
        'circle_radius', 'polygon_style',
    ];

    public function index(Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map);

        $options = ['campaign' => $campaign->id, 'map' => $map->id];
        $model = $map;

        Datagrid::layout(\App\Renderers\Layouts\Map\Marker::class)
            ->route('maps.map_markers.index', $options);
        $rows = $map
            ->markers()
            ->sort(request()->only(['o', 'k']), ['id' => 'desc'])
            ->with(['map'])
            ->paginate(15);
        if (request()->ajax()) {
            return $this->datagridAjax($rows);
        }

        return view('maps.markers.index', compact('campaign', 'rows', 'model'));
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

        $source = null;
        if (request()->has('source')) {
            $source = MapMarker::findOrFail(request()->get('source'));
            FormCopy::source($source);
        }

        $activeTab = 1;
        if ($source) {
            $activeTab = $source->shape_id;
        }

        return view(
            'maps.markers.create',
            compact('campaign', 'map', 'source', 'activeTab')
        );
    }

    /**
     * @param Map $map
     * @param StoreMapMarker $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Campaign $campaign, Map $map, StoreMapMarker $request)
    {
        $this->authorize('update', $map);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $model = new MapMarker();
        $data = $request->only($this->fields);
        $data['map_id'] = $map->id;
        $new = $model->create($data);

        if ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', ['campaign' => $campaign->id, $map->id, 'focus' => $new->id])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', [$campaign->id, $map->id, $new])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->get('from') == 'explore') {
            return redirect()
                ->route('maps.explore', ['campaign' => $campaign->id, $map->id, 'focus' => $new->id]);
        }

        return redirect()
            ->route('maps.map_markers.index', [$campaign->id, $map->id, 'focus' => $new->id])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Map $map, MapMarker $mapMarker, string $from = '')
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $from = request()->get('from');
        $model = $mapMarker;
        $includeMap = true;
        $activeTab = $mapMarker->shape_id;

        return view('maps.markers.edit', compact(
            'campaign',
            'map',
            'model',
            'includeMap',
            'activeTab',
            'from'
        ));
    }

    /**
     * @param StoreMapMarker $request
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapMarker $request, Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only($this->fields);
        if (!request()->has('entity_id') && !isset($data['entity_id'])) {
            $data['entity_id'] = null;
        }
        $mapMarker->update($data);

        if ($request->has('submit-explore')) {
            return redirect()
                ->route('maps.explore', ['campaign' => $map->campaign_id, $map, 'focus' => $mapMarker->id])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', ['campaign' => $map->campaign_id, $map, $mapMarker])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        }
        return redirect()
            ->route('maps.map_markers.index', ['campaign' => $map->campaign_id, $map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $mapMarker->delete();

        if (request()->get('from') == 'map') {
            return redirect()
                ->to($map->getLink('explore'));
        }

        return redirect()
            ->route('maps.map_markers.index', [$campaign->id, $map->id])
            ->withSuccess(__('maps/markers.delete.success', ['name' => $mapMarker->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function details(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        if (auth()->check()) {
            $this->authorize('view', $map);
            if ($mapMarker->entity_id) {
                // No access to the child? 404
                if (empty($mapMarker->entity->child)) {
                    abort(404);
                }
                $this->authorize('view', $mapMarker->entity->child);
            }
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $map);
            if ($mapMarker->entity_id) {
                $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $mapMarker->entity->child, $mapMarker->entity->typeId());
            }
        }

        $name = $mapMarker->name;
        if ($mapMarker->entity) {
            $name = '<a href="' . $mapMarker->entity->url() . '" target="_blank">';
            if (!empty($mapMarker->name)) {
                $name .= $mapMarker->name;
            } else {
                $name .= $mapMarker->entity->name;
            }
            $name .= '</a>';
        }

        return response()->json([
            'body' => view('maps.markers.details', [
                'marker' => $mapMarker,
                'campaign' => $campaign,
            ])->render(),
            'name' => $name
        ]);
    }

    /**
     * @param Request $request
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function move(Request $request, Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $mapMarker->update($request->only('latitude', 'longitude'));

        return response()->json([
            'success' => true,
            'marker_id' => $mapMarker->id
        ]);
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
            return $this->bulkBatch($campaign, route('maps.markers.bulk', ['campaign' => $campaign, 'map' => $map]), '_map-marker', $models, $map);
        }

        $count = $this->bulkProcess($request, MapMarker::class);

        return redirect()
            ->route('maps.map_markers.index', [$campaign->id, $map->id])
            ->with('success', trans_choice('maps/markers.bulks.' . $action, $count, ['count' => $count]))
        ;
    }
}
