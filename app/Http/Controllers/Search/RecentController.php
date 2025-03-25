<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\RecentService;
use Illuminate\Http\JsonResponse;

/**
 * Controller that loads recently searched entities and other information for the search popout
 */
class RecentController extends Controller
{
    protected RecentService $service;

    public function __construct(RecentService $recentService)
    {
        $this->service = $recentService;
    }

    /**
     * Get a user's recent searches
     */
    public function index(Campaign $campaign): JsonResponse
    {
        $recent = [];
        $this->service->campaign($campaign);
        if (auth()->check()) {
            $recent = $this->service
                ->user(auth()->user())
                ->recent();
        }

        return response()->json([
            'recent' => $recent,
            'bookmarks' => $this->service->bookmarks(),
            'indexes' => $this->service->indexes(),
            'fulltext_route' => route('search.fulltext', [$campaign]),
            'texts' => [
                'recents' => __('search.lookup.recents'),
                'results' => __('search.lookup.results'),
                'bookmarks' => __('entities.bookmarks'),
                'index' => __('Lists'),
                'hint' => __('search.lookup.hint'),
                'fulltext' => __('search.fulltext'),
                'keyboard' => __('search.lookup.keyboard', [
                    'k' => '<strong>k</strong>',
                    'esc' => '<strong>esc</strong>',
                ]),
                'empty_results' => __('search.lookup.empty'),
            ],
        ]);
    }
}
