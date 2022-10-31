<?php

namespace App\Datagrids\Filters;

use App\Models\Location;

class LocationFilter extends DatagridFilter
{
    /**
     * Filters available for locations
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'parent_location_id',
                'label' => __('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  __('crud.placeholders.location'),
                'model' => Location::class,
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
