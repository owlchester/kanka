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
                'field' => 'location_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.location')]),
                'placeholder' => __('crud.placeholders.parent'),
                'model' => Location::class,
            ])
            ->add('is_destroyed')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntry()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
