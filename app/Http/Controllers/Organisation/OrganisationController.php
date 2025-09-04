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

        $options = ['campaign' => $campaign, 'organisation' => $organisation, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['organisation_id'] = $organisation->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Organisation\Organisation::class)
            ->route('organisations.organisations', $options);

        $this->rows = $organisation
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType',
                'entity.tags',
                'parent', 'parent.entity',
            ])
            ->filter($filters)
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('organisations.organisations', $organisation);
    }
}
