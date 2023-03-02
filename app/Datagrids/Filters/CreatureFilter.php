<?php

namespace App\Datagrids\Filters;

use App\Models\Creature;
use App\Models\Location;

class CreatureFilter extends DatagridFilter
{
    /**
     * Filters available for races
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'creature_id',
                'label' => __('creatures.fields.creature'),
                'type' => 'select2',
                'route' => route('creatures.find'),
                'placeholder' =>  __('crud.placeholders.creature'),
                'model' => Creature::class,
            ])
            ->location()
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
