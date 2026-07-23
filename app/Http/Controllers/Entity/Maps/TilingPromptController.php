<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Maps\TilingTriggerService;
use App\Traits\CampaignAware;
use Illuminate\Support\Carbon;

class TilingPromptController extends Controller
{
    use CampaignAware;

    public function __construct(protected TilingTriggerService $trigger) {}

    public function update(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign);
        // Explicitly scope the shared permission service to this campaign (mirroring
        // Entity\Maps\MarkerController::preview()'s comment) so `can('update', ...)` evaluates
        // the user's actual role rather than falling back to
        // EntityPermission::loadAllPermissions()'s "no campaign set" admin bypass.
        EntityPermission::campaign($campaign);
        abort_unless(auth()->user()->can('update', $entity), 403);

        if (! $entity->isMap()) {
            abort(404);
        }

        $map = $entity->child;
        $map->tiling_prompt_dismissed_at = Carbon::now();
        $map->saveQuietly();

        if (request()->input('action') === 'migrate' && $entity->image) {
            $this->trigger->maybeTrigger($entity->image, force: true);
        }

        return response()->json(['success' => true]);
    }
}
