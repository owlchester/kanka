<?php

namespace App\Datagrids\Filters;

use App\Models\Calendar;

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
                'field' => 'calendar_id',
                'label' => trans('crud.fields.calendar'),
                'type' => 'select2',
                'route' => route('calendars.find'),
                'placeholder' =>  trans('crud.placeholders.calendar'),
                'model' => Calendar::class,
            ])
            ->isPrivate()
            ->tags()
        ;
    }
}
