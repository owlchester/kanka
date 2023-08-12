<?php

namespace App\Http\Controllers\Organisation;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Organisation;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\GuestAuthTrait;

class OrganisationController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;

    public function organisations(Campaign $campaign, Organisation $organisation)
    {
        if (auth()->check()) {
            $this->authorize('view', $organisation);
        } else {
            $this->authorizeForGuest(CampaignPermission::ACTION_READ, $organisation, $organisation->entity->type_id);
        }

        $options = ['campaign' => $campaign, 'organisation' => $organisation];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['organisation_id'] = $organisation->id;
            $filters['organisation_id'] = $organisation->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Organisation\Organisation::class)
            ->route('organisations.organisations', $options);

        // @phpstan-ignore-next-line
        $this->rows = $organisation
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.tags',
                'organisation', 'organisation.entity'
            ])
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->menuView($organisation, 'organisations');
    }
}
