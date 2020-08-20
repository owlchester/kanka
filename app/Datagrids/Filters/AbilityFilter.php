<?php

namespace App\Datagrids\Filters;

use App\Models\Ability;

class AbilityFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'ability_id',
                'label' => trans('crud.fields.ability'),
                'type' => 'select2',
                'route' => route('abilities.find'),
                'placeholder' =>  trans('crud.placeholders.ability'),
                'model' => Ability::class,
            ])
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
