<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\MapFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreMap;
use App\Models\Campaign;
use App\Models\Map;
use App\Traits\TreeControllerTrait;

class MapController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected string $view = 'maps';
    protected string $route = 'maps';
    protected $module = 'maps';

    /**
     * Crud models
     */
    protected $model = \App\Models\Map::class;

    /** @var string Filter */
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
            return response()
                ->redirectToRoute('maps.show', [$campaign, $map->id])
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
}
