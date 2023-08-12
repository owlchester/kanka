<?php

namespace App\Http\Controllers\Maps;

use App\Datagrids\Filters\MapFilter;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreMap;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;
use App\Traits\TreeControllerTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Map $map)
    {
        $this->campaign($campaign)->authView($map);

        $options = ['campaign' => $campaign, 'map' => $map];
        $base = 'descendants';
        if (request()->has('map_id')) {
            $options['map_id'] = $map->id;
            $base = 'maps';
        }

        Datagrid::layout(\App\Renderers\Layouts\Map\Map::class)
            ->route('maps.maps', $options);


        $this->rows = $map
            ->{$base}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'map', 'map.entity'])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('maps.maps', $map);
    }
}
