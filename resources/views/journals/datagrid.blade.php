<?php /** @var \App\Models\Journal $model */?>

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
            'label' => __('journals.fields.date'),
            'field' => 'date',
            'render' => function ($model) {
                return \App\Facades\UserDate::format($model->date);
            }
        ],
        [
            'type' => 'calendar_date',
        ],
        [
            'field' => 'author.name',
            'label' => __('journals.fields.author'),
            'render' => function($model) {
                return $model->author ? $model->author->tooltipedLink() : null;
            },
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'journals.index',
        'baseRoute' => 'journals',
        'trans' => 'journals.fields.',
    ]
) !!}
