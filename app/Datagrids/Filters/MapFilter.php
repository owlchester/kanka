<?php

namespace App\Datagrids\Filters;

use App\Models\Map;

class MapFilter extends DatagridFilter
{
    /**
     * Filters available for maps
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'map_id',
                'label' => __('entities.map'),
                'type' => 'select2',
                'route' => route('maps.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.map'),
                'model' => Map::class,
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
