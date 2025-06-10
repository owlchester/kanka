<?php

namespace App\Http\Controllers\Filters;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Bookmarks\RoutingService;
use App\Services\FilterService;

class SaveController extends Controller
{
    public function __construct(
        protected FilterService $filterService,
        protected RoutingService $routingService)
    {
        $this->middleware(['auth']);
    }

    protected function render(Campaign $campaign, EntityType $entityType)
    {
        $mode = request()->get('m');

        return view('filters.save_form')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('mode', $mode);
    }

    public function save(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', Bookmark::class);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Check limit
        if (Bookmark::count() >= config('limits.campaigns.bookmarks') && ! $campaign->boosted()) {
            return redirect()->back()->withErrors(__('filters.bookmark.premium'));
        }

        $filters = '';
        if ($entityType->isSpecial()) {
            $filters = $this->filterService->clipboardFilters();
            $this->filterService
                ->entityType($entityType)
                ->build();
        } else {
            $this->filterService
                ->model($entityType->getClass())
                ->make($entityType->pluralCode());
            $filters = 'm=' . request()->get('m') . '&' . $this->filterService->clipboardFilters();
        }

        $bookmark = new Bookmark;
        $bookmark->campaign_id = $campaign->id;
        $bookmark->name = request()->get('name', __('filters.bookmark.name', ['module' => $entityType->plural()]));
        $bookmark->icon = request()->get('icon', null);
        $bookmark->entity_type_id = $entityType->id;
        $bookmark->filters = $filters;
        $bookmark->parent = $entityType->isSpecial() ? null : $entityType->pluralCode();
        $bookmark->save();

        $route = $this->routingService->campaign($campaign)->bookmark($bookmark)->url();

        return redirect()->to($route)->withSuccess(__('filters.bookmark.success'));
    }
}
