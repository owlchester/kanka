<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Actions\BookmarkDatagridActions;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreBookmark;
use App\Models\Campaign;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends CrudController
{
    /** @var string Config for the crudController*/
    protected string $view = 'bookmarks';
    protected string $route = 'bookmarks';

    protected bool $tabPermissions = false;
    protected bool $tabAttributes = false;
    protected bool $tabBoosted = false;
    protected bool $tabCopy = false;
    protected bool $hasLimitCheck = true;

    protected string $model = Bookmark::class;

    /**  */
    protected string $datagridActions = BookmarkDatagridActions::class;

    protected string $forceMode = 'table';

    protected function setNavActions(): CrudController
    {
        $this->addNavAction(
            route('bookmarks.reorder', $this->campaign),
            '<i class="fa-solid fa-arrow-up-arrow-down" aria-hidden="true"></i> <span class="hidden md:inline">' .
                __('bookmarks.reorder.title') . '</span>'
        );
        $this->addNavAction(
            route('campaign-sidebar', $this->campaign),
            '<i class="fa-solid fa-bars-staggered" aria-hidden="true"></i> <span class="hidden md:inline">' .
                __('bookmarks.actions.customise') . '</span>'
        );

        $this->addNavAction(
            '//docs.kanka.io/en/latest/advanced/bookmarks.html',
            '<i class="fa-solid fa-question-circle" aria-hidden="true"></i> <span class="hidden md:inline">' . __('crud.actions.help') . '</span>',
            '',
            true
        );
        return parent::setNavActions();
    }

    /**
     */
    public function index(Request $request, Campaign $campaign)
    {
        // Check that the user has permission to actually be here
        if (auth()->guest() || !auth()->user()->can('browse', new Bookmark())) {
            return redirect()->route('dashboard', $campaign);
        }
        return $this->campaign($campaign)->crudIndex($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookmark $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    /**
     * Redirect to the edit screen
     */
    public function show(Campaign $campaign, Bookmark $bookmark)
    {
        if (!auth()->check()) {
            abort(403);
        }
        return redirect()->route('bookmarks.edit', [$campaign, $bookmark]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Bookmark $bookmark)
    {
        return $this->campaign($campaign)->crudEdit($bookmark);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookmark $request, Campaign $campaign, Bookmark $bookmark)
    {

        $this->authorize('update', $bookmark);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        $bookmark->update($data);


        $link = '<a href="' . route(
            $this->view . '.show',
            [$campaign, $bookmark->id]
        )
            . '">' . $bookmark->name . '</a>';
        $success = __('general.success.updated', [
            'name' => $link
        ]);

        session()->flash('success_raw', $success);

        $options = [];
        $options = [$campaign, $bookmark] + $options;
        $route = route($this->view . '.show', $options + [$bookmark]);

        if ($request->has('submit-new')) {
            $route = route($this->route . '.create', $campaign);
        } elseif ($request->has('submit-update')) {
            $route = route($this->route . '.edit', [$campaign, $bookmark->id]);
        } elseif ($request->has('submit-close')) {
            $route = route($this->route . '.index', [$campaign]);
        } elseif ($request->has('submit-copy')) {
            $route = route($this->route . '.create', [$campaign, 'copy' => $bookmark->id]);
            return response()->redirectTo($route);
        }
        return response()->redirectTo($route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, Bookmark $bookmark)
    {
        return $this->campaign($campaign)->crudDestroy($bookmark);
    }

    /**
     */
    protected function limitCheckReached(): bool
    {
        return !$this->campaign->canHaveMoreBookmarks();
    }
}
