<?php /** @var \App\Models\Calendar $model */ ?>
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
            'render' => function($model) {
                return $model->date;
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
