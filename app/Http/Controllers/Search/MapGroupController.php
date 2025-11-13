<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Services\Search\MapGroupSearchService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;

class MapGroupController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected MapGroupSearchService $service) {}

    public function index(Request $request, Campaign $campaign, Map $map)
    {
        $this->campaign($campaign)->authEntityView($map->entity);

        return response()->json(
            $this->service
                ->campaign($campaign)
                ->map($map)
                ->request($request)
                ->search()
        );
    }
}
