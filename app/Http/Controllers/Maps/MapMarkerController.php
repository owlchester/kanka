<?php


namespace App\Http\Controllers\Maps;

use App\Facades\CampaignLocalization;
use App\Facades\FormCopy;
use App\Http\Controllers\Controller;
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
    use GuestAuthTrait;
    protected $model = Map::class;

    /**
     * @var array fields from the input sent to the model
     */
    protected $fields = [
        'entity_id', 'name', 'entry', 'longitude', 'latitude',
        'colour', 'font_colour', 'opacity',
        'shape_id',
        'type_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'visibility',
        'is_draggable',
        'group_id',
        'pin_size',
        'circle_radius', 'polygon_style',
    ];

    public function index(Map $map)
    {
        return redirect()->route('maps.show', $map);
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
            ->route('maps.edit', [$map, '#tab_form-markers', 'focus' => $new->id])
            ->withSuccess(__('maps/markers.create.success', ['name' => $new->name]));
    }

    /**
     * @param Map $map
     * @param MapMarker $mapMarker
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map);

        $ajax = request()->ajax();
        $model = $mapMarker;
        $includeMap = true;
        $activeTab = $mapMarker->shape_id;

        return view(
            'maps.markers.edit',
            compact('map', 'ajax', 'model', 'includeMap', 'activeTab')
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
            ->route('maps.edit', [$map, '#tab_form-markers'])
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

        $mapMarker->delete();

        if (request()->get('from') == 'map') {
            return redirect()
                ->route('maps.explore', $map);
        }

        return redirect()
            ->route('maps.edit', [$map, '#tab_form-markers'])
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

        return response()->json([
            'body' => view('maps.markers.details', ['marker' => $mapMarker])->render(),
            'name' => $mapMarker->name
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
}
