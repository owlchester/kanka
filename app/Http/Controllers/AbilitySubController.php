<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
use App\Models\Ability;
use App\Models\Campaign;

class AbilitySubController extends AbilityController
{
    /**
     */
    public function abilities(Campaign $campaign, Ability $ability)
    {
        $this->authCheck($ability);

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
            ->sort(request()->only(['o', 'k']))
            ->with(['entity', 'entity.image', 'ability', 'ability.entity'])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($ability, 'abilities');
    }

    /**
     */
    public function entities(Campaign $campaign, Ability $ability)
    {
        $this->authCheck($ability);

        Datagrid::layout(\App\Renderers\Layouts\Ability\Entity::class)
            ->route('abilities.entities', [$campaign, $ability]);

        $this->rows = $ability
            ->entities()
            ->sort(request()->only(['o', 'k']))
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return view('abilities.entities')
            ->with('campaign', $campaign)
            ->with('model', $ability)
            ->with('rows', $this->rows);
    }
}
