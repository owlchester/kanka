<?php

namespace App\Datagrids\Filters;

class CalendarFilter extends DatagridFilter
{
    /**
     * Filters available for calendars
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
