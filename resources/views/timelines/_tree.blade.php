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
        /*[
            'label' => trans('timelines.fields.timeline'),
            'field' => 'timeline.name',
            'render' => function($model) {
                if ($model->timeline) {
                    return $model->timeline->entity->tooltipedLink();
                }
            }
        ],*/
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines')),
            'render' => function($model) {
                return $model->timelines->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('timelines.fields.eras'),
            'render' => function($model) {
                return $model->eras->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'timelines.tree',
        'baseRoute' => 'timelines',
        'trans' => 'timelines.fields.',
        'campaignService' => $campaignService,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->timelines->count();
                }
            ]
        ]
    ]
) !!}
