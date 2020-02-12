<?php

namespace App\Datagrids\Filters;


use App\Models\Location;
use App\Models\Tag;

class CalendarFilter extends DatagridFilter
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
            ->tags()
        ;
    }
}
