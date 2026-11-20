<?php

namespace App\Datagrids\Filters;

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
            ->standardFilters();
    }
}
