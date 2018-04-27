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
        ],
        'is_pinned',
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'notes.index',
        'baseRoute' => 'notes',
        'trans' => 'notes.fields.',
        'campaign' => $campaign
    ]
) !!}