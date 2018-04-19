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
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'calendars.index',
        'baseRoute' => 'calendars',
        'trans' => 'calendars.fields.',
        'campaign' => $campaign
    ]
) !!}