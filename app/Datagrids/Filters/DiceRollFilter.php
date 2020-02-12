<?php

namespace App\Datagrids\Filters;

class DiceRollFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->character()
            ->isPrivate()
            ->tags()
        ;
    }
}
