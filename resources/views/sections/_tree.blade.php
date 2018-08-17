@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
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
            'label' => trans('sections.fields.sections'),
            'render' => function($model) {
                return $model->sections()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('sections.fields.section'),
            'render' => function($model) {
                if ($model->section) {
                    return '<a href="' . route('sections.show', $model->section->id) . '">' . $model->section->name . '</a>';
                }
            },
            'field' => 'section.name',
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'sections.tree',
        'baseRoute' => 'sections',
        'trans' => 'sections.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->sections()->count();
                }
            ]
        ]
    ]
) !!}