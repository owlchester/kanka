<?php /** @var \App\Models\AttributeTemplate $model */ ?>

{!! $datagrid
    ->columns([
        // Name
        'name',
        [
            'type' => 'parent',
        ],
       [
            'label' => __('attribute_templates.fields.attributes'),
            'render' => function($model) {
                return number_format($model->entity->attributes_count);
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
            'label' => __('attribute_templates.fields.is_enabled'),
            'field' => 'is_enabled',
            'render' => function($model) {
                if ($model->is_enabled) {
                    return '<i class="fa-solid fa-check" title="' . __('attribute_templates.fields.is_enabled') . '"></i>';
                }
                return '';
            },

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
