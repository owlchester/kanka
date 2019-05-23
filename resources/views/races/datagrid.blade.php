@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)->render(
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
        'route' => 'races.index',
        'baseRoute' => 'races',
        'trans' => 'races.fields.',
        'campaign' => $campaign
    ]
) !!}