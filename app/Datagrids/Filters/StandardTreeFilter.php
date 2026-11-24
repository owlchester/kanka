<?php

namespace App\Datagrids\Filters;

class StandardTreeFilter extends DatagridFilter
{
    public function build(): void
    {
        $this->add('name')
            ->add('type')
            ->parent($this->entityType->id)
            ->standardFilters();
    }
}
