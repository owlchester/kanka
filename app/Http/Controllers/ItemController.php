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
use App\Traits\TreeControllerTrait;
use App\Facades\Datagrid;

class ItemController extends CrudController
{
    use TreeControllerTrait;

    /**
     * @var string
     */
    protected $view = 'items';
    protected $route = 'items';
    protected $module = 'items';

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
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function inventories(Item $item)
    {
        return $this->menuView($item, 'inventories');
    }
    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function items(Item $item)
    {
        $this->authCheck($item);

        $options = ['item' => $item];
        $filters = [];

        Datagrid::layout(\App\Renderers\Layouts\Item\Item::class)
            ->route('items.items', $options);

        $this->rows = $item
            ->items()
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['entity', 'entity.image'])
            ->paginate(15);

        return $this->datagridAjax();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }
        return $this
            ->menuView($item, 'items');
    }
}
