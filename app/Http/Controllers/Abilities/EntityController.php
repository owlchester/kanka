<?php

namespace App\Http\Controllers\Abilities;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbilityEntity;
use App\Models\Campaign;
use App\Models\Ability;
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

    public function index(Campaign $campaign, Ability $ability)
    {
        $this->campaign($campaign)->authView($ability);

        $options = ['campaign' => $campaign, 'ability' => $ability];
        Datagrid::layout(\App\Renderers\Layouts\Ability\Ability::class)
            ->route('abilites.entities', $options);

        // @phpstan-ignore-next-line
        $this->rows = $ability
            ->entities()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('abilites.entities', $ability);
    }

    /**
     */
    public function create(Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability);
        $formOptions = ['abilities.entity-add.save', $campaign, 'ability' => $ability];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('abilities.entities.create', [
            'campaign' => $campaign,
            'model' => $ability,
            'formOptions' => $formOptions
        ]);
    }

    /**
     */
    public function store(StoreAbilityEntity $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability);
        $redirectUrlOptions = ['ability' => $ability->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['ability_id'] = $ability->id;
        }

        $ability->attachEntity($request->only('entity_id', 'visibility_id'));
        return redirect()->route('abilities.entities', [$campaign, 'ability' => $ability->id])
            ->with('success', trans('abilities.children.create.success', ['name' => $ability->name]));
    }
}
