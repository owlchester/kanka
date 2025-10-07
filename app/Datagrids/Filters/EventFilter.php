<?php

namespace App\Datagrids\Filters;

use App\Models\Event;

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
            ->add('date')
            ->add([
                'field' => 'event_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.event')]),
                'placeholder' => __('crud.placeholders.parent'),
                'model' => Event::class,
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
