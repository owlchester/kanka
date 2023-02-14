<?php

namespace App\Datagrids\Filters;

use App\Models\Timeline;

class TimelineFilter extends DatagridFilter
{
    /**
     * Filters available for timelines
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'timeline_id',
                'label' => __('entities.timeline'),
                'type' => 'select2',
                'route' => route('timelines.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.timeline'),
                'model' => Timeline::class,
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
