<?php

namespace App\Http\Controllers\Maps;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class MapController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Map $map)
    {
        $this->campaign($campaign)->authEntityView($map->entity);

        $options = ['campaign' => $campaign, 'map' => $map, 'm' => $this->descendantsMode()];
        $base = 'descendants';
        if ($this->filterToDirect()) {
            $base = 'children';
        }

        Datagrid::layout(\App\Renderers\Layouts\Map\Map::class)
            ->route('maps.maps', $options);

        $this->rows = $map
            ->{$base}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'parent', 'parent.entity',
                'entity', 'entity.image', 'entity.entityType', 'entity.visibleTags',
            ])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('maps.maps', $map);
    }
}
