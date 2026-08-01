<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ExploreController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct()
    {
        $this->middleware('adless');
    }

    /**
     * Exploration view for a map
     */
    public function index(Campaign $campaign, Map $map)
    {
        if (empty($map->entity)) {
            abort(404);
        }

        return redirect()->route('entities.map', [$campaign, $map->entity]);
    }
}
