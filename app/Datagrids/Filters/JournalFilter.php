<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;

class JournalFilter extends DatagridFilter
{
    /**
     * Filters available for journals
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->dateRange()
            ->add([
                'field' => 'author_id',
                'label' => __('journals.fields.author'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations', $this->campaign),
                'placeholder' => __('journals.placeholders.author'),
                'model' => Entity::class,
            ])
            ->location()
            ->isPrivate()
            ->template()
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
