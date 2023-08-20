<?php

namespace App\Datagrids\Filters;

use App\Models\Location;

class LocationFilter extends DatagridFilter
{
    /**
     * Filters available for locations
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'parent_location_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('locations.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Location::class,
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
