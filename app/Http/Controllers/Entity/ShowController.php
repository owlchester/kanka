<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CachedResponse;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct()
    {

        $this->middleware([CachedResponse::class]);
    }

    public function index(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        /*if ($entity->slug !== $slug) {
            return redirect()->route('entities.show', [$campaign, $entity, $entity->slug]);
        }*/

        // Perf trick
        if ($entity->hasChild()) {
            $entity->child->setRelation('entity', $entity);
        }

        $bookmark = null;
        if ($request->filled('bookmark')) {
            $bookmark = Bookmark::where('id', $request->get('bookmark'))
                ->where('campaign_id', $campaign->id)
                ->first();
        }

        return view('cruds.show')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('entityType', $entity->entityType)
            ->with('bookmark', $bookmark);
    }
}
