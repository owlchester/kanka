@inject ('datagrid', 'App\Renderers\DatagridRenderer')
<?php /** @var \App\Models\Timeline $model */?>
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
        [
            'label' => __('timelines.fields.eras'),
            'render' => function($model) {
                return $model->eras()->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'timelines.index',
        'baseRoute' => 'timelines',
        'trans' => 'timelines.fields.',
        'campaign' => $campaign
    ]
) !!}
