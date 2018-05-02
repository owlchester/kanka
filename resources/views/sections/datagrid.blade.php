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
            'label' => trans('crud.fields.section'),
            'field' => 'section.name',
            'render' => function($model) {
                if ($model->section) {
                    return '<a href="' . route('sections.show', $model->section->id) . '">' . $model->section->name . '</a>';
                }
            }
        ],
        [
            'label' => trans('sections.fields.sections'),
            'render' => function($model) {
                $total = $model->sections->count();
                foreach ($model->descendants()->with('sections')->get() as $child) {
                    $total += $child->sections->count();
                }
                return $total;
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('sections.fields.children'),
            'render' => function($model) {
                $total = $model->allChildren()->count();
                return $total;
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
        'route' => 'sections.index',
        'baseRoute' => 'sections',
        'trans' => 'sections.fields.',
    ]
) !!}