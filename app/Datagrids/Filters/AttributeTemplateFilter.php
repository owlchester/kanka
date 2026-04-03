<?php

namespace App\Datagrids\Filters;

use App\Models\AttributeTemplate;

class AttributeTemplateFilter extends DatagridFilter
{
    /**
     * Filters available for attribute templates
     */
    public function build()
    {
        $this
            ->add('name')
            ->parent(config('entities.ids.attribute_template'))
            ->add('is_enabled')
            ->isPrivate()
            ->template()
            ->archived()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
