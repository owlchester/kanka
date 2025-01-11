<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\MapFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreMap;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Map;

class MapController extends CrudController
{
    protected string $view = 'maps';
    protected string $route = 'maps';
    protected string $module = 'maps';

    protected string $model = Map::class;

    protected string $filter = MapFilter::class;


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMap $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Map $map)
    {
        return $this->campaign($campaign)->crudShow($map);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Map $map)
    {
        // Can't edit a map being chunked
        if ($map->isChunked() && $map->chunkingRunning()) {
            return redirect()
                ->to($map->getLink())
                ->with('error', __('maps.errors.chunking.running.edit') . ' ' . __('maps.errors.chunking.running.time'));
        }
        return $this->campaign($campaign)->crudEdit($map);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMap $request, Campaign $campaign, Map $map)
    {
        return $this->campaign($campaign)->crudUpdate($request, $map);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Map $map)
    {
        return $this->campaign($campaign)->crudDestroy($map);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.map'))->first();
    }
}
