<?php /** @var \App\Models\Journal $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        'date',
        [
            'type' => 'calendar_date',
        ],
        // Author
        [
            'type' => 'avatar',
            'parent' => 'author',
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
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'journals.index',
        'baseRoute' => 'journals',
        'trans' => 'journals.fields.',
        'campaign' => $campaign
    ]
) !!}
