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
    protected $tabCopy = false;

    protected $bulkTemplates = false;

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

        $this->indexActions[] = [
            'label' => '<i class="fas fa-arrows-alt-v"></i> <span class="hidden-xs">' . __('timelines.actions.reorder') . '</span>',
            'route' => route('quick-links.reorder'),
            'class' => 'default',
            'policy' => 'browse'
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
        if (!auth()->check()) {
            abort(403);
        }
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

    /**
     * Random entity
     * @param MenuLink $menuLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function random(MenuLink $menuLink)
    {
        $route = $menuLink->randomEntity();

        if (empty($route)) {
            return redirect()
                ->route('dashboard')
                ->with('error',
                    __('menu_links.random_no_entity')
                );
        }
        return redirect()->to($route);
    }
}
