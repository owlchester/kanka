<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderMenuLinks;
use App\Models\MenuLink;
use App\Services\MenuLinkService;

class QuickLinkController extends Controller
{
    protected MenuLinkService $service;

    public function __construct(MenuLinkService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reorder()
    {
        $this->authorize('create', MenuLink::class);

        $links = MenuLink::ordered()->get();

        return view('menu_links.reorder', compact(
            'links'
        ));
    }

    /**
     * @param ReorderMenuLinks $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(ReorderMenuLinks $request)
    {
        $this->authorize('create', MenuLink::class);

        $this->service
            ->reorder($request);

        return redirect()
            ->route('menu_links.index')
            ->with('success', __('menu_links.reorder.success'));
    }
}
