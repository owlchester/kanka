<?php

namespace App\Datagrids\Filters;

class DiceRollFilter extends DatagridFilter
{
    /**
     * Filters available for dice rolls
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
