<?php

namespace App\Datagrids\Filters;

class FamilyFilter extends DatagridFilter
{
    /**
     * Filters available for families
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.family'))
            ->location()
            ->character('member_id')
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
