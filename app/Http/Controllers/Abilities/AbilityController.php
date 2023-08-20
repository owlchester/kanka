<?php

namespace App\Http\Controllers\Abilities;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Ability;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class AbilityController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Ability $ability)
    {
        $this->campaign($campaign)->authView($ability);

        $options = ['campaign' => $campaign, 'ability' => $ability];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $ability->id;
            $filters['ability_id'] = $ability->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Ability\Ability::class)
            ->route('abilities.abilities', $options);

        // @phpstan-ignore-next-line
        $this->rows = $ability
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'entity.image', 'ability', 'ability.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('abilities.abilities', $ability);
    }
}
