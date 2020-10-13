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
        // Character
        [
            'type' => 'avatar',
            'parent' => 'character',
            'parent_route' => 'characters',
            'visible' => $campaign->enabled('characters'),
        ],
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
