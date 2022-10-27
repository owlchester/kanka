<?php

namespace App\Datagrids\Filters;

use App\Models\Race;
use App\Models\Location;

class RaceFilter extends DatagridFilter
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
                'field' => 'race_id',
                'label' => __('characters.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
            ])
            ->add([
                'field' => 'location_id',
                'label' => __('crud.fields.location'),
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
