<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\MenuLinkDatagridActions;
use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreMenuLink;
use App\Models\Campaign;
use App\Models\MenuLink;
use Illuminate\Http\Request;

class MenuLinkController extends CrudController
{
    /** @var string Config for the crudController*/
    protected string $view = 'menu_links';
    protected string $route = 'menu_links';

    protected bool $tabPermissions = false;
    protected bool $tabAttributes = false;
    protected bool $tabBoosted = false;
    protected bool $tabCopy = false;

    /** @var string */
    protected $model = \App\Models\MenuLink::class;

    /** @var string */
    protected $datagridActions = MenuLinkDatagridActions::class;

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->filters = [
            'name',
        ];

        $this->addNavAction(
            route('quick-links.reorder'),
            '<i class="fa-solid fa-arrows-alt-v"></i> <span class="hidden-xs">' .
                __('timelines.actions.reorder') . '</span>'
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request)
    {
        // Check that the user has permission to actually be here
        if (auth()->guest() || !auth()->user()->can('browse', new MenuLink())) {
            return redirect()->route('dashboard');
        }
        return $this->crudIndex($request);
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
     * Redirect to the edit screen
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(MenuLink $menuLink)
    {
        if (!auth()->check()) {
            abort(403);
        }
        return redirect()->route('menu_links.edit', $menuLink);
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
                ->with(
                    'error',
                    __('menu_links.random_no_entity')
                );
        }
        return redirect()->to($route);
    }

    /**
     * @return bool
     */
    protected function limitCheckReached(): bool
    {
        $campaign = CampaignLocalization::getCampaign();
        return !$campaign->canHaveMoreQuickLinks();
    }
}
