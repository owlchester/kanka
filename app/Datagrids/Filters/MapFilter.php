<?php

namespace App\Datagrids\Filters;

use App\Models\Map;

class MapFilter extends DatagridFilter
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
                'field' => 'map_id',
                'label' => trans('crud.fields.map'),
                'type' => 'select2',
                'route' => route('maps.find'),
                'placeholder' =>  trans('crud.placeholders.map'),
                'model' => Map::class,
            ])
            ->location()
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
