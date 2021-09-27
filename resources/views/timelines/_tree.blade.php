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
            'label' => trans('timelines.fields.timelines'),
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
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'timelines.tree',
        'baseRoute' => 'timelines',
        'trans' => 'timelines.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->timelines->count();
                }
            ]
        ]
    ]
) !!}
