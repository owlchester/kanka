<?php

namespace App\Datagrids\Filters;

use App\Models\Ability;

class AbilityFilter extends DatagridFilter
{
    /**
     * Filters available for abilities
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'ability_id',
                'label' => __('crud.fields.ability'),
                'type' => 'select2',
                'route' => route('abilities.find'),
                'placeholder' =>  __('crud.placeholders.ability'),
                'model' => Ability::class,
            ])
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
