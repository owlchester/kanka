<?php

namespace App\Http\Controllers\Abilities;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Campaign;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class AbilityController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Ability $ability)
    {
        $this->campaign($campaign)->authEntityView($ability->entity);

        return redirect()->route('entities.children', [$campaign, $ability->entity]);
    }
}
