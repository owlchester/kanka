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
            'label' => '<i class="ra ra-tower" title="' . __('quests.fields.locations') . '"></i>',
            'visible' => $campaign->enabled('locations'),
            'render' => function($model) {
                return $model->locations->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa fa-user" title="' . __('quests.fields.characters') . '"></i>',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="ra ra-hood" title="' . __('quests.fields.organisations') . '"></i>',
            'visible' => $campaign->enabled('organisations'),
            'render' => function($model) {
                return $model->organisations->count();
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
