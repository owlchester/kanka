<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\ItemFilter;
use App\Models\Character;
use App\Http\Requests\StoreItem;
use App\Models\Item;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'items';
    protected $route = 'items';

    /** @var string Model */
    protected $model = \App\Models\Item::class;

    /** @var string Filter */
    protected $filter = ItemFilter::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $this->crudShow($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return $this->crudEdit($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreItem $request, Item $item)
    {
        return $this->crudUpdate($request, $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        return $this->crudDestroy($item);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quests(Item $item)
    {
        return $this->menuView($item, 'quests');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function mapPoints(Item $item)
    {
        return $this->menuView($item, 'map-points', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function inventories(Item $item)
    {
        return $this->menuView($item, 'inventories');
    }
}
