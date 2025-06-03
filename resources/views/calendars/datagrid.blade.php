<?php
/** @var \App\Models\Calendar $model */
use \App\Models\Calendar;
?>
{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'type' => 'parent',
        ],
        [
            'label' => __('calendars.fields.date'),
            'render' => function(Calendar $model) {
                return $model->date;
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-cake" title="' . trans('crud.tabs.reminders') . '"></i>',
            'render' => function(Calendar $model) {
                return number_format($model->calendar_events_count);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'calendars.index',
        'baseRoute' => 'calendars',
        'trans' => 'calendars.fields.',
    ]
) !!}
