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
            'label' => trans('crud.fields.tag'),
            'field' => 'tag.name',
            'render' => function($model) {
                if ($model->tag) {
                    return '<a href="' . route('tags.show', $model->tag->id) . '">' . $model->tag->name . '</a>';
                }
            }
        ],
        [
            'label' => trans('tags.fields.tags'),
            'render' => function($model) {
                $total = $model->tags->count();
                foreach ($model->descendants()->with('tags')->get() as $child) {
                    $total += $child->tags->count();
                }
                return $total;
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('tags.fields.children'),
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
        'route' => 'tags.index',
        'baseRoute' => 'tags',
        'trans' => 'tags.fields.',
    ]
) !!}