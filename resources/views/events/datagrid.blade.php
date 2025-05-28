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
            'label' => '<i class="' . \App\Facades\Module::duoIcon('event') . '" title="' . \App\Facades\Module::plural(config('entities.ids.event'), __('entities.events')) . '"></i>',
            'render' => function($model) {
                return number_format($model->children_count);
            },
            'disableSort' => true,
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
