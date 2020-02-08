<?php

namespace App\Http\Controllers;

use App\Datagrids\MenuLinkDatagrid;
use App\Http\Requests\StoreMenuLink;
use App\Models\MenuLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuLinkController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'menu_links';
    protected $route = 'menu_links';

    protected $tabPermissions = false;
    protected $tabAttributes = false;
    protected $tabBoosted = false;

    /**
     * @var string
     */
    protected $model = \App\Models\MenuLink::class;

    /**
     * @var string
     */
    protected $datagrid = MenuLinkDatagrid::class;

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuLink $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(MenuLink $menuLink)
    {
        return $this->crudShow($menuLink);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuLink $menuLink)
    {
        return $this->crudEdit($menuLink);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMenuLink $request, MenuLink $menuLink)
    {
        return $this->crudUpdate($request, $menuLink);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuLink $menuLink)
    {
        return $this->crudDestroy($menuLink);
    }
}
