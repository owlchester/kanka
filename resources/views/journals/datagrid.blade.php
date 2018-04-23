@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
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
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
            'label' => trans('journals.fields.author')
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