<?php /** @var \App\Models\Event $model */ ?>

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
        'date',
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'events.index',
        'baseRoute' => 'events',
        'trans' => 'events.fields.',
    ]
) !!}
