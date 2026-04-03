<?php

namespace App\Datagrids\Filters;

class CreatureFilter extends DatagridFilter
{
    /**
     * Filters available for creatures
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.creature'))
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
