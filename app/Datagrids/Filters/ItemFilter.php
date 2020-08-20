<?php

namespace App\Datagrids\Filters;

class ItemFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('size')
            ->location()
            ->character()
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
