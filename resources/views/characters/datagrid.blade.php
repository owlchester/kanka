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
        [
            'label' => trans('characters.fields.family'),
            'visible' => $campaign->enabled('families'),
            'render' => function($model) {
                if ($model->family) {
                    return '<a href="' . route('families.show', $model->family->id) . '}">' . $model->family->name . '</a>';
                }
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        'age',
        'race',
        'sex',
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'characters.index',
        'baseRoute' => 'characters',
        'trans' => 'characters.fields.',
        'campaign' => $campaign
    ]
) !!}