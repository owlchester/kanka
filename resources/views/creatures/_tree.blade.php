@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.creature'), __('entities.creatures')),
            'render' => function($model) {
                return $model->creatures->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
            'render' => function($model) {
                $locations = [];
                foreach ($model->locations as $location) {
                    $locations[] = $location->tooltipedLink();
                }
                return implode( ', ', $locations);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'creatures.tree',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
        'campaignService' => $campaignService,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->creatures->count();
                }
            ],
        ]
    ]
) !!}
