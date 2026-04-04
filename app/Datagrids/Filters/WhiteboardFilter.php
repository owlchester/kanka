<?php

namespace App\Datagrids\Filters;

class WhiteboardFilter extends DatagridFilter
{
    /**
     * Filters available for timelines
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.whiteboard'))
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
