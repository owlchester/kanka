<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;

class WhiteboardFilter extends DatagridFilter
{
    /**
     * Filters available for timelines
     */
    public function build()
    {
        $name = Module::singular(config('entities.ids.whiteboard'));
        $placeholder = __('crud.placeholders.whiteboard');
        if (! empty($name)) {
            $placeholder = __('crud.placeholders.fallback', ['module' => $name]);
        }
        $this
            ->add('name')
            ->add('type')
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
