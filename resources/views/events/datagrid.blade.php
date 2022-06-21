@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
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
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'label' => trans('events.fields.event'),
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
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'events.index',
        'baseRoute' => 'events',
        'trans' => 'events.fields.',
        'campaignService' => $campaignService
    ]
) !!}
