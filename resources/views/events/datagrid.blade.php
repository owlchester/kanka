@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
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
        'date',
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('crud.fields.parent'),
            'field' => 'event.name',
            'render' => function($model) {
                if ($model->event) {
                    return $model->event->entity->tooltipedLink();
                }
            }
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'events.index',
        'baseRoute' => 'events',
        'trans' => 'events.fields.',
    ]
) !!}
