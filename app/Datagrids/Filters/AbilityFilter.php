<?php

namespace App\Datagrids\Filters;

use App\Models\Ability;

class AbilityFilter extends DatagridFilter
{
    /**
     * Filters available for abilities
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.ability'))
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
