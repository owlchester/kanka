<?php /** @var \App\Models\Note $model */ ?>

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
            'label' => '<i class="' . \App\Facades\Module::duoIcon('note') . '" title="' . \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')) . '"></i>',
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
        'route' => 'notes.index',
        'baseRoute' => 'notes',
        'trans' => 'notes.fields.',
    ]
) !!}
