<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Map;
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
        abort_unless(auth()->user()->can('update', $entity), 403);

        if (! $entity->isMap()) {
            abort(404);
        }

        /** @var Map $map */
        $map = $entity->child;
        $map->tiling_prompt_dismissed_at = Carbon::now();
        $map->saveQuietly();

        if (request()->input('action') === 'migrate' && $entity->image) {
            $this->trigger->maybeTrigger($entity->image, force: true);
        }

        return response()->json(['success' => true]);
    }
}
