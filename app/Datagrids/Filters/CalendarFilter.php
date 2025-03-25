<?php

namespace App\Datagrids\Filters;

class CalendarFilter extends DatagridFilter
{
    /**
     * Filters available for calendars
     */
    public function build()
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
            ->connections();
    }
}
