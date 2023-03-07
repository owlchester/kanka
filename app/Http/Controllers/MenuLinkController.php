<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\MenuLinkDatagridActions;
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
    protected bool $hasLimitCheck = true;

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
    }

    /**
     */
    public function index(Request $request, Campaign $campaign)
    {
        $this->addNavAction(
            route('quick-links.reorder', [$campaign]),
            '<i class="fa-solid fa-arrows-alt-v" aria-hidden="true"></i> <span class="hidden-xs">' .
            __('menu_links.reorder.title') . '</span>'
        );
        $this->addNavAction(
            route('campaign-sidebar', $campaign),
            '<i class="fa-solid fa-cog" aria-hidden="true"></i> <span class="hidden-xs">' .
            __('menu_links.actions.customise') . '</span>'
        );
        $this->addNavAction(
            '//docs.kanka.io/en/latest/advanced/quick-links.html',
            '<i class="fa-solid fa-question-circle" aria-hidden="true"></i> <span class="hidden-xs">' . __('crud.actions.help') . '</span>',
            'default',
            true
        );

        // Check that the user has permission to actually be here
        if (auth()->guest() || !auth()->user()->can('browse', new MenuLink())) {
            return redirect()->route('dashboard', [$campaign]);
        }
        return $this->campaign($campaign)->crudIndex($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuLink $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Redirect to the edit screen
     */
    public function show(Campaign $campaign, MenuLink $menuLink)
    {
        if (!auth()->check()) {
            abort(403);
        }
        return redirect()->to($menuLink->getLink('edit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, MenuLink $menuLink)
    {
        return $this->campaign($campaign)->crudEdit($menuLink);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMenuLink $request, Campaign $campaign, MenuLink $menuLink)
    {
        return $this->campaign($campaign)->crudUpdate($request, $menuLink);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, MenuLink $menuLink)
    {
        return $this->campaign($campaign)->crudDestroy($menuLink);
    }

    /**
     * Random entity
     * @param MenuLink $menuLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function random(Campaign $campaign, MenuLink $menuLink)
    {
        $route = $menuLink->randomEntity();

        if (empty($route)) {
            return redirect()
                ->route('dashboard', [$campaign])
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
        return !$this->campaign->canHaveMoreQuickLinks();
    }
}
