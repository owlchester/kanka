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
        [
            'label' => __('conversations.fields.participants'),
            'field' => 'target_id',
            'render' => function($model) {
                return __('conversations.targets.' . ($model->forCharacters() ? 'characters' : 'members'));
            },
        ],
        [
            'label' => __('conversations.fields.participants'),
            'render' => function($model) {
                return $model->participants()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('conversations.fields.messages'),
            'render' => function($model) {
                return $model->messages()->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ],
    ])
    ->options([
        'route' => 'conversations.index',
        'baseRoute' => 'conversations',
        'trans' => 'conversations.fields.',
    ]
) !!}
