<?php

namespace App\Http\Controllers\Items;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Item;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class EntityController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Item $item)
    {
        $this->campaign($campaign)->authEntityView($item->entity);

        $options = ['campaign' => $campaign, 'item' => $item];

        Datagrid::layout(\App\Renderers\Layouts\Item\Entity::class)
            ->route('items.inventories', $options);

        $this->rows = $item
            ->entities()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['image', 'entityType', 'visibleTags'])
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('items.entities', $item);
    }
}
