<?php

namespace App\Datagrids\Filters;

use App\Models\Calendar;

class TimelineFilter extends DatagridFilter
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
