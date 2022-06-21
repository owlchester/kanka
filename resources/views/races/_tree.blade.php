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
        /*[
            'label' => __('characters.fields.race'),
            'field' => 'race.name',
            'visible' => $campaignService->enabled('races'),
            'render' => function($model) {
                if ($model->race) {
                    return $model->race->tooltipedLink();
                }
            }
        ],*/
        [
            'label' => __('races.fields.races'),
            'render' => function($model) {
                return $model->races->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('races.fields.characters'),
            'visible' => $campaignService->enabled('characters'),
            'render' => function($model) {
                return $model->characters()->count() . ' / ' . $model->allCharacters(true)->count();
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
        'campaignService' => $campaignService,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->races->count();
                }
            ],
        ]
    ]
) !!}
