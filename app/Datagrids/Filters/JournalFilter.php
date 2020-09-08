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
            ->date()
            ->character()
            ->location()
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
