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
        [
            'label' => __('calendars.fields.date'),
            'render' => function($model) {
                return $model->date;
            },
            'disableSort' => true,
        ],
        [
            'field' => 'calendar_id',
            'label' => trans('calendars.fields.calendar'),
            'visible' => $campaign->enabled('calendars'),
            'render' => function($model) {
                return $model->calendar ? $model->calendar->tooltipedLink() : null;
            },
        ],
        [
            'label' => trans('calendars.fields.calendars'),
            'visible' => $campaign->enabled('calendars'),
            'render' => function($model) {
                return $model->calendars->count();
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
