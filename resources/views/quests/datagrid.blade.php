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
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
            'label' => __('quests.fields.character'),
        ],
        [
            'label' => __('quests.fields.quest'),
            'field' => 'quest.name',
            'render' => function($model) {
                if ($model->quest) {
                    return '<a href="' . route('quests.show', $model->quest->id) . '">' . e($model->quest->name) . '</a>';
                }
            }
        ],
        [
            'label' => __('quests.show.tabs.elements'),
            'render' => function($model) {
                return $model->elements()->has('entity')->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa fa-check-circle" title="' . __('quests.fields.is_completed') . '"></i>',
            'render' => function ($model) {
                return $model->is_completed ? '<i class="fa fa-check-circle" title="' . __('quests.fields.is_completed') . '"></i>' : null;
            },
            'field' => 'is_completed',
        ],
        [
            'type' => 'calendar_date',
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'quests.index',
        'baseRoute' => 'quests',
        'trans' => 'quests.fields.',
        'campaign' => $campaign
    ]
) !!}
