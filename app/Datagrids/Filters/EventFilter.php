<?php

namespace App\Datagrids\Filters;

use App\Models\Event;

class EventFilter extends DatagridFilter
{
    /**
     * Filters available for events
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('date')
            ->add([
                'field' => 'event_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('events.find'),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Event::class,
            ])
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
