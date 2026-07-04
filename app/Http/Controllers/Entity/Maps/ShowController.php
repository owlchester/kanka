<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ShowController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        /** @var Map $map */
        $map = $entity->child;

        if (! $map->explorable()) {
            return redirect()
                ->route('entities.show', [$campaign, $entity])
                ->withError(__('maps.errors.explore.missing'));
        }

        if ($map->isChunked() && ! $map->chunkingReady()) {
            return redirect()->route('entities.show', [$campaign, $entity]);
        }

        return view('entities.pages.map.index', compact('campaign', 'entity'));
    }
}
