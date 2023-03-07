@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
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
            'label' => __('calendars.fields.date'),
            'render' => function($model) {
                return $model->date;
            },
            'disableSort' => true,
        ],
        [
            'label' => __('calendars.fields.calendars'),
            'visible' => $campaign->enabled('calendars'),
            'render' => function($model) {
                return $model->calendars->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'calendars.tree',
        'baseRoute' => 'calendars',
        'trans' => 'calendars.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->calendars->count();
                }
            ]
        ]
    ]
) !!}
