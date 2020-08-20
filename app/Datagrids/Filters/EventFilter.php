<?php

namespace App\Datagrids\Filters;

class EventFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('date')
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
