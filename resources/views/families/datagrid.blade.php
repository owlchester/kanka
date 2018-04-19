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
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => trans('families.fields.members'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->members()->count();
            }
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'families.index',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
        'campaign' => $campaign
    ]
) !!}