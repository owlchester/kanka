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

class ItemController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Item $item)
    {
        $this->campaign($campaign)->authEntityView($item->entity);

        $options = ['campaign' => $campaign, 'item' => $item];
        $filters = [];

        Datagrid::layout(\App\Renderers\Layouts\Item\Item::class)
            ->route('items.items', $options);

        $this->rows = $item
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with(['entity', 'entity.image'])
            ->paginate(15);

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('items.items', $item);
    }
}
