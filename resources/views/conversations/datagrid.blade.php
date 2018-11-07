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
        [
            'label' => trans('conversations.fields.target'),
            'field' => 'target',
            'render' => function($model) {
                return trans('conversations.targets.' . $model->target);
            },
        ],
        [
            'label' => trans('conversations.fields.participants'),
            'render' => function($model) {
                return $model->participants()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('conversations.fields.messages'),
            'render' => function($model) {
                return $model->messages()->count();
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
        'route' => 'conversations.index',
        'baseRoute' => 'conversations',
        'trans' => 'conversations.fields.',
        'campaign' => $campaign
    ]
) !!}