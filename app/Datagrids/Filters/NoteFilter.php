<?php

namespace App\Datagrids\Filters;

class NoteFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}
