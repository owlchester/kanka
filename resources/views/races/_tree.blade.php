@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->filters($filters)
    ->nested()
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
            'label' => trans('characters.fields.race'),
            'field' => 'race.name',
            'visible' => $campaign->enabled('races'),
            'render' => function($model) {
                if ($model->race) {
                    return '<a href="' . route('races.show', $model->race_id) . '" data-toggle="tooltip" title="' . $model->race->tooltipWithName() . '" data-html="true">' . e($model->race->name) . '</a>';
                }
            }
        ],
        [
            'label' => trans('races.fields.races'),
            'render' => function($model) {
                return $model->races()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('races.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters()->count();
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
        'route' => 'races.tree',
        'baseRoute' => 'races',
        'trans' => 'races.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->races()->count();
                }
            ],
        ]
    ]
) !!}