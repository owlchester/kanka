@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->service($filterService)
    ->models($models)
    ->columns([
        // Name
        'name',
        [
            'label' => __('crud.fields.parent'),
            'field' => 'attributeTemplate.name',
            'render' => function($model) {
                if ($model->attributeTemplate) {
                return $model->attributeTemplate->tooltipedLink();
                }
            }
        ],
       [
            'label' => __('attribute_templates.fields.attributes'),
            'render' => function($model) {
                return $model->entity->attributes()->count();
            },
            'disableSort' => true,
        ],
       [
            'label' => __('attribute_templates.fields.auto_apply'),
            'render' => function($model) {
                return $model->entityType ? $model->entityType->name() : null;
            },
            'field' => 'entity_type_id'
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'attribute_templates.index',
        'baseRoute' => 'attribute_templates',
        'trans' => 'attribute_templates.fields.',
    ]
) !!}
