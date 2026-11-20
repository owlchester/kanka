<?php

namespace App\Http\Controllers\Bookmarks;

use App\Datagrids\Actions\BookmarkDatagridActions;
use App\Facades\Module;
use App\Http\Controllers\CampaignTableController;
use App\Http\Requests\StoreBookmark;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Campaign\Sidebar\SetupService;
use App\Services\DashboardService;
use App\Services\Entity\TagFormSyncService;
use Illuminate\Http\Request;

class BookmarkController extends CampaignTableController
{
    protected string $view = 'bookmarks';

    protected string $route = 'bookmarks';

    protected string $model = Bookmark::class;

    protected string $datagridActions = BookmarkDatagridActions::class;

    public function index(Request $request, Campaign $campaign)
    {
        // Check that the user has permission to actually be here
        if (! $this->authorize('browse', [new Bookmark, $campaign])) {
            return redirect()->route('dashboard', $campaign);
        }

        return parent::index($request, $campaign);
    }

    public function create(Campaign $campaign)
    {
        $this->campaign($campaign);
        $type = $this->getEntityType();
        $this->authorize('create', [$type, $campaign]);
        if (! $campaign->canHaveMoreBookmarks()) {
            return view('cruds.forms.limit', [
                'campaign' => $campaign,
                'limit' => config('limits.campaigns.bookmarks'),
                'thing' => __('entities.bookmarks'),
                'doc' => '/advanced/bookmarks.html',
                'name' => $this->view,
            ]);
        }

        $singular = Module::singular($type->id);

        return view('bookmarks.forms.create', [
            'campaign' => $campaign,
            'name' => $this->view,
            'title' => empty($singular) ? __('bookmarks.create.title') : __('crud.titles.new', ['module' => $singular]),
            'plural' => Module::plural($type->id, __('entities.bookmarks')),
            'dashboards' => $this->dashboardOptions(),
            'parents' => $this->sidebarParents(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookmark $request, Campaign $campaign, TagFormSyncService $tags)
    {
        $this->authorize('create', [$this->getEntityType(), $campaign]);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        if (! $campaign->canHaveMoreBookmarks()) {
            return redirect()->back();
        }

        $bookmark = Bookmark::create($request->validated() + ['campaign_id' => $campaign->id]);
        $tags->sync($bookmark, $request);
        $link = '<a href="' . route('bookmarks.show', [$campaign, $bookmark]) . '" class="text-link">' . e($bookmark->name) . '</a>';
        session()->flash('success_raw', __('general.success.created', ['name' => $link]));

        return match (true) {
            $request->has('submit-new') => redirect()->route('bookmarks.create', $campaign),
            $request->has('submit-update') => redirect()->route('bookmarks.edit', [$campaign, $bookmark]),
            $request->has('submit-copy') => redirect()->route('bookmarks.create', [$campaign, 'copy' => $bookmark->id]),
            default => redirect()->route('bookmarks.index', $campaign),
        };
    }

    /**
     * Redirect to the edit screen
     */
    public function show(Campaign $campaign, Bookmark $bookmark)
    {
        if (! auth()->check()) {
            abort(403);
        }

        return redirect()->route('bookmarks.edit', [$campaign, $bookmark]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, Bookmark $bookmark)
    {
        $this->authorize('update', $bookmark);
        $this->campaign($campaign);

        return view('bookmarks.forms.edit', [
            'campaign' => $campaign,
            'model' => $bookmark,
            'name' => $this->view,
            'dashboards' => $this->dashboardOptions(),
            'parents' => $this->sidebarParents(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookmark $request, Campaign $campaign, Bookmark $bookmark, TagFormSyncService $tags)
    {

        $this->authorize('update', $bookmark);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        $bookmark->update($data);
        $tags->sync($bookmark, $request);

        $link = '<a href="' . route(
            $this->view . '.edit',
            [$campaign, $bookmark->id]
        )
            . '" class="text-link">' . $bookmark->name . '</a>';
        $success = __('general.success.updated', [
            'name' => $link,
        ]);

        $options = [];
        $options = [$campaign, $bookmark] + $options;
        $route = route($this->view . '.edit', $options + [$bookmark]);

        if ($request->has('submit-new')) {
            $route = route($this->route . '.create', $campaign);
        } elseif ($request->has('submit-update')) {
            $route = route($this->route . '.edit', [$campaign, $bookmark->id]);
        } elseif ($request->has('submit-close')) {
            $route = route($this->route . '.index', [$campaign]);
        } elseif ($request->has('submit-copy')) {
            $route = route($this->route . '.create', [$campaign, 'copy' => $bookmark->id]);

            return response()->redirectTo($route)->with('success_raw', $success);
        }

        return response()->redirectTo($route)->with('success_raw', $success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::findOrFail(config('entities.ids.bookmark'));
    }

    protected function dashboardOptions(): array
    {
        if (auth()->guest()) {
            return [];
        }
        /** @var DashboardService $service */
        $service = app()->make(DashboardService::class);
        $dashboards = $service->campaign($this->campaign)->user(auth()->user())->getDashboards();
        $dashboardOptions = ['' => ''];
        foreach ($dashboards as $dashboard) {
            $dashboardOptions[$dashboard->id] = $dashboard->name;
        }

        return $dashboardOptions;
    }

    protected function sidebarParents(): array
    {
        /** @var SetupService $service */
        $service = app()->make(SetupService::class);

        return $service->campaign($this->campaign)->availableParents();
    }
}
