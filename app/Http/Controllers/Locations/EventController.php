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

class EventController extends Controller
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
        if (request()->has('parent_id')) {
            $options['parent_id'] = $location->id;
            $filters['location_id'] = $location->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Location\Event::class)
            ->route('locations.events', $options);

        $this->rows = $location
            ->allEvents()
            ->filter($filters)
            ->filteredEvents()
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return redirect()->to($location->getLink());
    }
}
