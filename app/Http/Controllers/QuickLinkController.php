<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderMenuLinks;
use App\Http\Requests\ReorderStories;
use App\Models\Entity;
use App\Models\MenuLink;
use App\Services\MenuLinkService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuickLinkController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

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
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param Request $request
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
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
