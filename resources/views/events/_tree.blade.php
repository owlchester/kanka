@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        'date',
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.event'), __('entities.events')),
            'field' => 'event.name',
            'render' => function($model) {
                return $model->descendants->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'events.index',
        'baseRoute' => 'events',
        'trans' => 'events.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->events->count();
                }
            ]
        ]
    ]
) !!}
