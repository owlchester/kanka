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
            ->add([
                'field' => 'location_id',
                'label' => __('entities.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  __('crud.placeholders.location'),
                'model' => Location::class,
                'withChildren' => true,
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
