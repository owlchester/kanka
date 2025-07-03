<?php

namespace App\Http\Controllers\Characters;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Character;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class MemberController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Character $character)
    {
        $this->campaign($campaign)->authEntityView($character->entity);

        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
            ->route('characters.organisations', [$character]);

        $this->rows = $character
            ->organisationMemberships()
            ->with([
                'organisation.entity', 'organisation.entity.image',
                'organisation.entity.entityType' => function ($sub) {
                    $sub->select('id', 'code');
                },
                'organisation.entity.visibleTags',
            ])
            ->rows()
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('characters.organisations', $character);
    }
}
