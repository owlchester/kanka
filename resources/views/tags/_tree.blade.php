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
            'label' => __('calendars.fields.colour'),
            'field' => 'tag.colour',
            'render' => function ($model) {
                /** @var \App\Models\Tag $model */
                if (!$model->hasColour()) {
                    return '';
                }
                return '<span class="p-1 rounded text-xs ' . $model->colourClass() . '">' . __('colours.' . $model->colour) . '</span>';
            }
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags')),
            'render' => function($model) {
                return $model->tags->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('tags.fields.children'),
            'render' => function($model) {
                $total = $model->entities->count();
                return $total;
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-tag" data-title="' . __('tags.fields.is_auto_applied') . '" data-toggle="tooltip"></i>',
            'field' => 'is_auto_applied',
            'render' => function($model) {
                if ($model->isAutoApplied()) {
                    return '<i class="fa-solid fa-tag" data-title="' . __('tags.fields.is_auto_applied') . '" data-toggle="tooltip"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'label' => '<i class="fa-solid fa-eye" data-title="' . __('tags.fields.is_hidden') . '" data-toggle="tooltip"></i>',
            'field' => 'is_hidden',
            'render' => function($model) {
                if ($model->isHidden()) {
                    return '<i class="fa-solid fa-eye-slash" data-title="' . __('tags.fields.is_hidden') . '" data-toggle="tooltip"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'tags.tree',
        'baseRoute' => 'tags',
        'trans' => 'tags.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->tags->count();
                }
            ]
        ]
    ]
) !!}
