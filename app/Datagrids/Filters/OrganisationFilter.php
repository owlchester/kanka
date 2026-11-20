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
            ->add('status_id')
            ->standardFilters();
    }
}
