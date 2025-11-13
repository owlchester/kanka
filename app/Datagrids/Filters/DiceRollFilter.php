<?php

namespace App\Datagrids\Filters;

class DiceRollFilter extends DatagridFilter
{
    /**
     * Filters available for dice rolls
     */
    public function build()
    {
        $this
            ->add('name')
            ->character()
            ->isPrivate()
            ->archived()
            ->tags();
    }
}
