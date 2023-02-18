<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderMenuLinks;
use App\Models\Campaign;
use App\Models\MenuLink;
use App\Services\MenuLinkService;

class QuickLinkController extends Controller
{
    /** @var MenuLinkService */
    protected $service;

    /**
     * AbilityController constructor.
     * @param MenuLinkService $service
     */
    public function __construct(MenuLinkService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reorder(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', MenuLink::class);

        $links = MenuLink::ordered()->get();

        return view('menu_links.reorder', compact(
            'campaign',
            'links'
        ));
    }

    /**
     * @param ReorderMenuLinks $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(ReorderMenuLinks $request, Campaign $campaign)
    {
        $this->authorize('create', MenuLink::class);

        $this->service
            ->reorder($request);

        return redirect()
            ->route('menu_links.index', $campaign->id)
            ->with('success', __('menu_links.reorder.success'));
    }
}
