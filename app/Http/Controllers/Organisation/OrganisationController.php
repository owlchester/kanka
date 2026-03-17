<?php

namespace App\Http\Controllers\Organisation;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class OrganisationController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function organisations(Campaign $campaign, Organisation $organisation)
    {
        $this->campaign($campaign)->authEntityView($organisation->entity);

        return redirect()->route('entities.children', [$campaign, $organisation->entity]);
    }
}
