<?php

namespace App\Http\Controllers\Filters;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\FilterService;

class SaveController extends Controller
{
    protected FilterService $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->middleware(['auth']);
        $this->filterService = $filterService;
    }

    public function save(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', Bookmark::class);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        // Check limit
        if (Bookmark::count() >= config('limits.campaigns.bookmarks') && !$campaign->boosted()) {
            return redirect()->back()->withErrors(__('filters.bookmark.premium'));
        }

        $this->filterService
            ->model($entityType->getClass())
            ->make($entityType->pluralCode());
        $filters = 'm=' . request()->get('m') . '&' . $this->filterService->clipboardFilters();

        $bookmark = new Bookmark();
        $bookmark->campaign_id = $campaign->id;
        $bookmark->name = $entityType->name() . ' (filtered)';
        $bookmark->type = $entityType->code;
        $bookmark->filters = $filters;
        $bookmark->parent = $entityType->pluralCode();
        $bookmark->save();

        return redirect()->to($bookmark->getRoute())->withSuccess(__('filters.bookmark.success'));
    }
}
