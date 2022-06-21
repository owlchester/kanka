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
            'label' => __('characters.fields.race'),
            'field' => 'race.name',
            'visible' => $campaignService->enabled('races'),
            'render' => function($model) {
                if ($model->race) {
                    return $model->race->tooltipedLink();
                }
            }
        ],
        [
            'label' => __('races.fields.characters'),
            'visible' => $campaignService->enabled('characters'),
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
        'campaignService' => $campaignService
    ]
) !!}
