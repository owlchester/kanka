<?php

namespace App\Datagrids\Filters;

class JournalFilter extends DatagridFilter
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
            ->character()
            ->location()
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
