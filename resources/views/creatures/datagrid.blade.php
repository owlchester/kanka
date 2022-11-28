@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
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
            'label' => __('creatures.fields.creatures'),
            'render' => function($model) {
                return $model->creatures->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'creatures.index',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
        'campaignService' => $campaignService
    ]
) !!}
