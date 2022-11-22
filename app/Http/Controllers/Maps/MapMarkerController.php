<?php


namespace App\Http\Controllers\Maps;

use App\Facades\CampaignLocalization;
use App\Facades\FormCopy;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Http\Requests\StoreMapMarker;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;

class MapMarkerController extends Controller
{
    /**
     * Auth for guests with model
     */
    use GuestAuthTrait, BulkControllerTrait;

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

    public function index(Map $map)
    {
        $this->authorize('update', $map);

        $campaign = CampaignLocalization::getCampaign();
        $options = ['map' => $map->id];
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

    public function show(Map $map)
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
            compact('map', 'ajax', 'source', 'activeTab')
        );
    }

    /**
     * @param Map $map
     * @param StoreMapMarker $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Map $map, StoreMapMarker $request)
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
                ->route('maps.explore', [$map, 'focus' => $new->id])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', [$map, $new])
                ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
        } elseif ($request->get('from') == 'explore') {
            return redirect()
                ->route('maps.explore', [$map, 'focus' => $new->id]);
        }

        return redirect()
            ->route('maps.map_markers.index', [$map, 'focus' => $new->id])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Map $map, MapMarker $mapMarker, string $from = '' )
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $ajax = request()->ajax();
        $from = request()->get('from');
        $model = $mapMarker;
        $includeMap = true;
        $activeTab = $mapMarker->shape_id;

        return view(
            'maps.markers.edit',
            compact('map', 'ajax', 'model', 'includeMap', 'activeTab', 'from')
        );
    }

    /**
     * @param StoreMapMarker $request
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreMapMarker $request, Map $map, MapMarker $mapMarker)
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
                ->route('maps.explore', [$map, 'focus' => $mapMarker->id])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('maps.map_markers.edit', [$map, $mapMarker])
                ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
        }
        return redirect()
            ->route('maps.map_markers.index', [$map, '#tab_form-markers'])
            ->withSuccess(__('maps/markers.edit.success', ['name' => $mapMarker->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);
        if ($mapMarker->map_id !== $map->id) {
            abort(503);
        }

        $mapMarker->delete();

        if (request()->get('from') == 'map') {
            return redirect()
                ->route('maps.explore', $map);
        }

        return redirect()
            ->route('maps.map_markers.index', [$map])
            ->withSuccess(__('maps/markers.delete.success', ['name' => $mapMarker->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function details(Map $map, MapMarker $mapMarker)
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

        $campaign = CampaignLocalization::getCampaign();

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
    public function move(Request $request, Map $map, MapMarker $mapMarker)
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
    public function bulk(Request $request, Map $map)
    {
        $this->authorize('update', $map);
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->bulkBatch(route('maps.markers.bulk', ['map' => $map]), '_map-marker', $models, $map);
        }

        $count = $this->bulkProcess($request, MapMarker::class);

        return redirect()
            ->route('maps.map_markers.index', ['map' => $map])
            ->with('success', trans_choice('maps/markers.bulks.' . $action, $count, ['count' => $count]))
        ;
    }
}
