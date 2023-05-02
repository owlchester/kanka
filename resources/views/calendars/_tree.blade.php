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
            'label' => __('calendars.fields.date'),
            'render' => function($model) {
                return $model->date;
            },
            'disableSort' => true,
        ],
        /*[
            'field' => 'calendar_id',
            'label' => trans('calendars.fields.calendar'),
            'visible' => $campaignService->enabled('calendars'),
            'render' => function($model) {
                return $model->calendar ? $model->calendar->tooltipedLink() : null;
            },
        ],*/
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.calendar'), __('entities.calendars')),
            'visible' => $campaignService->enabled('calendars'),
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
