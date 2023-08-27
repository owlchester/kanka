<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\ItemFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreItem;
use App\Models\Campaign;
use App\Models\Item;
use App\Traits\TreeControllerTrait;

class ItemController extends CrudController
{
    use TreeControllerTrait;

    /**
     */
    protected string $view = 'items';
    protected string $route = 'items';
    protected $module = 'items';

    /** @var string Model */
    protected $model = \App\Models\Item::class;

    /** @var string Filter */
    protected string $filter = ItemFilter::class;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItem $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Item $item)
    {
        return $this->campaign($campaign)->crudShow($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Item $item)
    {
        return $this->campaign($campaign)->crudEdit($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreItem $request, Campaign $campaign, Item $item)
    {
        return $this->campaign($campaign)->crudUpdate($request, $item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Item $item)
    {
        return $this->campaign($campaign)->crudDestroy($item);
    }
}
