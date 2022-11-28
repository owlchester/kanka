<?php

namespace App\Datagrids\Filters;

use App\Models\Timeline;

class TimelineFilter extends DatagridFilter
{
    /**
     * Filters available for timelines
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'timeline_id',
                'label' => __('entities.timeline'),
                'type' => 'select2',
                'route' => route('timelines.find'),
                'placeholder' =>  __('crud.placeholders.timeline'),
                'model' => Timeline::class,
            ])
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
