<?php

namespace App\Datagrids\Filters;

use App\Models\Calendar;
use App\Models\Timeline;

class TimelineFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'timeline_id',
                'label' => __('crud.fields.timeline'),
                'type' => 'select2',
                'route' => route('timelines.find'),
                'placeholder' =>  __('crud.placeholders.timeline'),
                'model' => Timeline::class,
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
