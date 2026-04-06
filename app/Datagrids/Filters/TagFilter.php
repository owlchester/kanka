<?php

namespace App\Datagrids\Filters;

class TagFilter extends DatagridFilter
{
    /**
     * Filters available for tags
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.tag'))
            ->add('is_auto_applied')
            ->isPrivate()
            ->template()
            ->archived()
            ->hasImage()
            ->hasEntry()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->attributes()
            ->connections();
    }
}
