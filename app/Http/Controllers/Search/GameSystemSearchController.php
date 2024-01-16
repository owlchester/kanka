<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use App\Models\GameSystem;

/**
 * Controller that loads popular game systems
 */
class GameSystemSearchController extends Controller
{
    /**
     * Get a user's recent searches
     */
    public function index(Campaign $campaign): JsonResponse
    {
        /** @var GameSystem[] $systems */
        $systems = GameSystem::where('name', 'like', '%' . request()->get('q') . '%')
            ->withCount('campaignSystem')->orderBy('campaign_system_count', 'desc')
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

        return response()->json(
            $formatted ?? []
        );
    }
}
