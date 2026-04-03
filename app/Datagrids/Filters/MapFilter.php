<?php

namespace App\Datagrids\Filters;

use App\Models\Map;

class MapFilter extends DatagridFilter
{
    /**
     * Filters available for maps
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.map'))
            ->location()
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
