<?php

namespace App\Http\Controllers\Maps;

use App\Datagrids\Bulks\MapBulk;
use App\Datagrids\Filters\MapFilter;
use App\Datagrids\Sorters\MapMapSorter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreMap;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\TreeControllerTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MapController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'maps';
    protected $route = 'maps';

    /**
     * Crud models
     */
    protected $model = \App\Models\Map::class;

    /** @var string Filter */
    protected $filter = MapFilter::class;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMap $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        return $this->crudShow($map);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map $map
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        return $this->crudEdit($map);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map $map
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMap $request, Map $map)
    {
        return $this->crudUpdate($request, $map);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        return $this->crudDestroy($map);
    }

    /**
     * @param Map $map
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function maps(Map $map)
    {
        return $this->datagridSorter(MapMapSorter::class)
            ->menuView($map, 'maps');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Map $map)
    {
        return $this->menuView($map, 'map-points', true);
    }

    /**
     * Exploration view for a map
     * @param Map $map
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function explore(Map $map)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $map);
        } else {
            $this->authorizeForGuest('read', $map);
        }

        if (empty($map->image)) {
            return redirect()->back()->withError(__('maps.errors.explore.missing'));
        }
        return view('maps.explore', compact('map'));
    }

    /**
     * Map ticker for updates to pointers
     * @param Map $map
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function ticker(Map $map)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $map);
        } else {
            $this->authorizeForGuest('read', $map);
        }

        $timestamp = request()->get('ts', time());
        /** @var MapMarker[] $markers */
        $markers = $map->markers()->where('updated_at', '>=', $timestamp)->get();
        $data = [];
        foreach ($markers as $marker) {
            $data[] = [
                'id' => $marker->id,
                'longitude' => $marker->longitude,
                'latitude' => $marker->latitude,
            ];
        }

        return response()->json([
            'ts' => Carbon::now(),
            'markers' => $data,
        ]);
    }
}
