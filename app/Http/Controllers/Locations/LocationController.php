<?php

namespace App\Http\Controllers\Locations;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Location;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class LocationController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Location $location)
    {
        $this->campaign($campaign)->authEntityView($location->entity);

        $options = ['campaign' => $campaign, 'location' => $location];
        $filters = [];
        if ($this->filterToDirect()) {
            $options['parent_id'] = $location->id;
            $filters['location_id'] = $location->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Location\Location::class)
            ->route('locations.locations', $options);

        $this->rows = $location
            ->descendants()
            ->select(['id', 'name', 'type', 'location_id', 'is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'entity', 'entity.image', 'entity.tags', 'entity.tags.entity',
                'parent', 'parent.entity',
            ])
            ->has('entity')
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('locations.locations', $location)
        ;
    }
}
