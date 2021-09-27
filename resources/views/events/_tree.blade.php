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
        'date',
        /*[
            'label' => trans('events.fields.event'),
            'field' => 'event.name',
            'render' => function($model) {
                if ($model->event) {
                    return $model->event->entity->tooltipedLink();
                }
            }
        ],*/
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => trans('events.fields.events'),
            'field' => 'event.name',
            'render' => function($model) {
                return $model->descendants->count();
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
        'route' => 'events.tree',
        'baseRoute' => 'events',
        'trans' => 'events.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->events->count();
                }
            ]
        ]
    ]
) !!}
