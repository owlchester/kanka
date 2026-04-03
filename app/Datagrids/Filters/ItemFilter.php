<?php

namespace App\Datagrids\Filters;

class ItemFilter extends DatagridFilter
{
    /**
     * Filters available for items
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('size')
            ->add('weight')
            ->add('is_equipped')
            ->parent(config('entities.ids.item'))
            ->location()
            ->character()
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
