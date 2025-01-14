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

        if ($entityType->isSpecial()) {
            $this->filterService
                ->entityType($entityType)
                ->build();
        } else {
            $this->filterService
                ->model($entityType->getClass())
                ->make($entityType->pluralCode());
        }

        $filters = 'm=' . request()->get('m') . '&' . $this->filterService->clipboardFilters();

        $bookmark = new Bookmark();
        $bookmark->campaign_id = $campaign->id;
        $bookmark->name = __('filters.bookmark.name', ['module' => $entityType->plural()]);
        $bookmark->entity_type_id = $entityType->id;
        $bookmark->filters = $filters;
        $bookmark->parent = $entityType->isSpecial() ? null : $entityType->pluralCode();
        $bookmark->save();

        return redirect()->to($bookmark->getRoute())->withSuccess(__('filters.bookmark.success'));
    }
}
