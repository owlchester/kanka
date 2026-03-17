<?php

namespace App\Http\Controllers\Creatures;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Creature;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class CreatureController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Creature $creature)
    {
        $this->campaign($campaign)->authEntityView($creature->entity);

        return redirect()->route('entities.children', [$campaign, $creature->entity]);
    }
}
