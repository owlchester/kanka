@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
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
            'label' => trans('locations.fields.locations'),
            'render' => function($model) {
                return $model->locations()->count();
            }
        ],
        [
            'label' => trans('locations.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters->count();
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
        'route' => 'locations.tree',
        'baseRoute' => 'locations',
        'trans' => 'locations.fields.',
    ]
) !!}