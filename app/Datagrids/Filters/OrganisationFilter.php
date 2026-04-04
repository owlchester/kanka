<?php

namespace App\Datagrids\Filters;

class OrganisationFilter extends DatagridFilter
{
    /**
     * Filters available for organisations
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.organisation'))
            ->locations()
            ->character('member_id')
            ->add('is_defunct')
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
