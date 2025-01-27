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
        $this->campaign($campaign)->authEntityView($ability->entity);

        $options = ['campaign' => $campaign, 'ability' => $ability];
        Datagrid::layout(\App\Renderers\Layouts\Ability\Entity::class)
            ->route('abilities.entities', $options);

        $this->rows = $ability
            ->entities()
            ->with(['image', 'visibleTags'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('abilities.entities', $ability);
    }

    public function create(Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability->entity);
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

    public function store(StoreAbilityEntity $request, Campaign $campaign, Ability $ability)
    {
        $this->authorize('update', $ability->entity);
        $redirectUrlOptions = ['ability' => $ability->id];
        if (request()->has('from-children')) {
            $redirectUrlOptions['ability_id'] = $ability->id;
        }

        $count = $ability->attachEntity($request->only('entities', 'visibility_id'));

        return redirect()->route('abilities.entities', [$campaign, 'ability' => $ability->id])
            //->with('success', __('abilities.children.create.success', ['name' => $ability->name]));
            ->with('success', trans_choice('abilities.children.create.attach_success', $count, ['count' => $count, 'name' => $ability->name]));

    }
}
