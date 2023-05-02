<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;
use App\Models\Timeline;

class TimelineFilter extends DatagridFilter
{
    /**
     * Filters available for timelines
     */
    public function __construct()
    {
        $name = Module::singular(config('entities.ids.timeline'));
        $placeholder = __('crud.placeholders.timeline');
        if (!empty($name)) {
            $placeholder = __('crud.placeholders.fallback', ['module' => $name]);
        }
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'timeline_id',
                'label' => Module::singular(config('entities.ids.timeline'), __('entities.timeline')),
                'type' => 'select2',
                'route' => route('timelines.find'),
                'placeholder' =>  $placeholder,
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
