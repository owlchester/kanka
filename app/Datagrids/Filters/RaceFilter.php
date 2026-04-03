<?php

namespace App\Datagrids\Filters;

class RaceFilter extends DatagridFilter
{
    /**
     * Filters available for races
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.race'))
            ->locations()
            ->add('status_id')
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
