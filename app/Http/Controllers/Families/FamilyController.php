<?php

namespace App\Http\Controllers\Families;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Family;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class FamilyController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Family $family)
    {
        $this->campaign($campaign)->authEntityView($family->entity);

        $options = ['campaign' => $campaign, 'family' => $family, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['parent'] = $family->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Family\Family::class)
            ->route('families.families', $options);

        // @phpstan-ignore-next-line
        $this->rows = $family
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'location', 'location.entity',
                'entity', 'entity.image', 'entity.entityType', 'entity.visibleTags',
                'parent', 'parent.entity',
            ])
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('families.families', $family);
    }
}
