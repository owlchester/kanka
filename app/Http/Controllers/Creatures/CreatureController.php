<?php

namespace App\Http\Controllers\Creatures;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Creature;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class CreatureController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Creature $creature)
    {
        $this->campaign($campaign)->authEntityView($creature->entity);

        $options = ['campaign' => $campaign, 'creature' => $creature, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['creature_id'] = $creature->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Creature\Creature::class)
            ->route('creatures.creatures', $options);

        // @phpstan-ignore-next-line
        $this->rows = $creature
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'entity', 'entity.image', 'entity.entityType', 'entity.visibleTags',
                'parent', 'parent.entity',
            ])
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('creatures.creatures', $creature);
    }
}
