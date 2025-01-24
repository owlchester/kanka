<?php /** @var \App\Models\Timeline $model */?>
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
            'label' => __('timelines.fields.eras'),
            'render' => function($model) {
                return number_format($model->eras_count);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'timelines.index',
        'baseRoute' => 'timelines',
        'trans' => 'timelines.fields.',
    ])
; !!}
