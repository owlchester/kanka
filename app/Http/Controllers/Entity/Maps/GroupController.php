<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExploreMapGroup;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function store(StoreExploreMapGroup $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        // Mirrors Entity/Maps/MarkerController::store() — scope EntityPermission to this
        // campaign so the update check below evaluates the user's actual role.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $map = $entity->child;
        $this->authorize('addGroup', [$map, $campaign]);

        $group = $this->createAtPosition($map, $request->validated());

        return response()->json(new GroupResource($group), 201);
    }

    /**
     * Insert the new group at the requested slot in the map's single, flat, 1-indexed
     * position sequence (matching the pre-existing MapGroupObserver/ReorderTrait
     * convention — see the note at the top of this task). Mirrors the legacy
     * Maps\GroupController::store()'s insert-and-shift pattern: bump every group at or
     * after the target position back by one via a query-builder mass update (this
     * bypasses MapGroupObserver, so it doesn't cascade into a reorder() per shifted row),
     * then create the new group at that now-vacated slot. MapGroupObserver::created()
     * fires once for that final create and renormalizes the whole map to a clean 1..N
     * sequence, confirming the order this method just produced.
     *
     * @param  array<string, mixed>  $data
     */
    protected function createAtPosition(Map $map, array $data): MapGroup
    {
        $afterId = $data['after_id'] ?? null;
        unset($data['after_id']);

        return DB::transaction(function () use ($map, $data, $afterId) {
            $position = 1;
            if ($afterId !== null) {
                $after = MapGroup::findOrFail($afterId);
                $position = $after->position + 1;
            }

            $map->groups()->where('position', '>=', $position)->increment('position');

            return MapGroup::create($data + [
                'map_id' => $map->id,
                'position' => $position,
            ]);
        });
    }
}
