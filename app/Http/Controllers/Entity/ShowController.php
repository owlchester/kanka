<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CachedResponse;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ShowController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct()
    {

        $this->middleware([CachedResponse::class]);
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        /*if ($entity->slug !== $slug) {
            return redirect()->route('entities.show', [$campaign, $entity, $entity->slug]);
        }*/

        // Perf trick
        if ($entity->hasChild()) {
            $entity->child->setRelation('entity', $entity);
        }

        return view('cruds.show')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('entityType', $entity->entityType);
    }
}
