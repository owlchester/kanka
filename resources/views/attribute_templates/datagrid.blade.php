@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
        [
            'label' => trans('attribute_templates.fields.attribute_template'),
            'field' => 'attributeTemplate.name',
            'render' => function($model) {
                if ($model->attributeTemplate) {
                    return '<a href="' . route('attribute_templates.show', $model->attributeTemplate->id) . '">' . e($model->attributeTemplate->name) . '</a>';
                }
            }
        ],
       [
            'label' => trans('attribute_templates.fields.attributes'),
            'render' => function($model) {
                return $model->entity->attributes()->count();
            },
            'disableSort' => true,
        ],
       [
            'label' => trans('crud.fields.entity_type'),
            'render' => function($model) {
                return $model->entityType ? $model->entityType->name() : null;
            },
            'field' => 'entity_type_id'
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'attribute_templates.index',
        'baseRoute' => 'attribute_templates',
        'trans' => 'attribute_templates.fields.',
        'campaign' => $campaign
    ]
) !!}