<?php

namespace App\Datagrids\Filters;

use App\Models\Event;

class EventFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('date')
            ->add([
                'field' => 'event_id',
                'label' => __('crud.fields.event'),
                'type' => 'select2',
                'route' => route('events.find'),
                'placeholder' =>  __('crud.placeholders.event'),
                'model' => Event::class,
            ])
            ->isPrivate()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
        ;
    }
}
