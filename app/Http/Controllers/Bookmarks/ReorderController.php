<?php

namespace App\Http\Controllers\Bookmarks;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderBookmarks;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Services\BookmarkService;

class ReorderController extends Controller
{
    protected BookmarkService $service;

    public function __construct(BookmarkService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('create', Bookmark::class);

        $links = Bookmark::ordered()->with(['target', 'entityType'])->get();

        return view('bookmarks.reorder', compact(
            'links',
            'campaign'
        ));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(ReorderBookmarks $request, Campaign $campaign)
    {
        $this->authorize('create', Bookmark::class);

        $this->service
            ->reorder($request);

        return redirect()
            ->route('bookmarks.index', $campaign)
            ->with('success', __('bookmarks.reorder.success'));
    }
}
