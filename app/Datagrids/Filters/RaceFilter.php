<?php

namespace App\Datagrids\Filters;

use App\Models\Race;
use App\Models\Location;

class RaceFilter extends DatagridFilter
{
    /**
     * Filters available for races
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'race_id',
                'label' => __('races.fields.race'),
                'type' => 'select2',
                'route' => route('races.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
            ])
            ->add([
                'field' => 'location_id',
                'label' => __('entities.location'),
                'type' => 'select2',
                'route' => route('locations.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.location'),
                'model' => Location::class,
                'withChildren' => true,
            ])
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
