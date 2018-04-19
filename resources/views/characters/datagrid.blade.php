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
        'title',
        [
            'label' => trans('characters.fields.family'),
            'visible' => $campaign->enabled('families'),
            'render' => function($model) {
                if ($model->family) {
                    return '<a href="' . route('families.show', $model->family->id) . '}" data-toggle="tooltip" title="' . $model->family->tooltip() . '">' . $model->family->name . '</a>';
                }
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        'race',
        'type',
        'age',
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