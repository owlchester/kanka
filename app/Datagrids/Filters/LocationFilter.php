<?php

namespace App\Datagrids\Filters;

class LocationFilter extends DatagridFilter
{
    /**
     * Filters available for locations
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('title')
            ->add('type')
            ->add('status_id')
            ->parent(config('entities.ids.location'))
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
