<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\GameSystem;
use Illuminate\Http\JsonResponse;

/**
 * Controller that loads popular game systems
 */
class GameSystemSearchController extends Controller
{
    /**
     * Get a user's recent searches
     */
    public function index(): JsonResponse
    {
        /** @var GameSystem[] $systems */
        $systems = GameSystem::where('name', 'like', '%' . request()->get('q') . '%')
            ->withCount('campaignSystem')
            ->orderBy('campaign_system_count', 'desc')
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get();

        foreach ($systems as $system) {
            $format = [
                'id' => $system->id,
                'text' => $system->name,
            ];

            $formatted[] = $format;
        }

        // Add Other if it's empty
        if (empty($formatted)) {
            $other = GameSystem::where('name', 'Other')->first();
            $formatted[] = [
                'id' => $other->id,
                'text' => __('sidebar.other'),
            ];
        }

        return response()->json(
            $formatted
        );
    }
}
