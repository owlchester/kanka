<?php

namespace App\Datagrids\Filters;

class EventFilter extends DatagridFilter
{
    /**
     * Filters available for events
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.event'))
            ->add('date')
            ->locations()
            ->isPrivate()
            ->template()
            ->archived()
            ->hasImage()
            ->hasEntry()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
