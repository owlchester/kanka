<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Search\RecentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Controller that loads recently searched entities and other information for the search popout
 */
class RecentController extends Controller
{
    public function __construct(protected RecentService $recentService) {}

    /**
     * Get a user's recent searches
     */
    public function index(Campaign $campaign): JsonResponse
    {
        $recent = [];
        $this->recentService->campaign($campaign);
        if (Auth::check()) {
            $recent = $this->recentService
                ->user(Auth::user())
                ->recent();
        }

        return response()->json([
            'recent' => $recent,
            'bookmarks' => $this->recentService->bookmarks(),
            'indexes' => $this->recentService->indexes(),
            'fulltext_route' => route('search.fulltext', [$campaign]),
            'texts' => [
                'recents' => __('search.lookup.recents'),
                'results' => __('search.lookup.results'),
                'bookmarks' => __('entities.bookmarks'),
                'index' => __('search.lookup.lists'),
                'hint_entries' => __('search.lookup.hint_name'),
                'hint_fulltext' => __('search.lookup.hint_fulltext'),
                'entities' => __('entities.entries'),
                'everywhere' => __('search.everywhere'),
                'fulltext' => __('search.fulltext'),
                'keyboard' => __('search.lookup.keyboard', [
                    'k' => '<strong>k</strong>',
                    'esc' => '<strong>esc</strong>',
                ]),
                'pages' => __('search.lookup.pages'),
                'content_matches' => __('search.lookup.content_matches'),
                'no_results' => __('search.lookup.empty'),
            ],
        ]);
    }
}
