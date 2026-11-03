<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;

class EventFilter extends DatagridFilter
{
    /**
     * Filters available for events
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->parent(config('entities.ids.event'))
            ->add('date')
            ->locations()
            ->add([
                'field' => 'participants',
                'label' => __('events.participants.title'),
                'type' => 'selectMultiple',
                'route' => route('search.entities-with-relations', $this->campaign),
                'placeholder' => __('crud.placeholders.search'),
                'model' => Entity::class,
                'multiple' => true,
            ])
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
