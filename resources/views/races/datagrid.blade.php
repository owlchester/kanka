<?php /** @var \App\Models\Race $model */ ?>

{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'type' => 'parent',
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return number_format($model->characters_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>',
            'field' => 'is_extinct',
            'render' => function($model) {
                if ($model->isExtinct()) {
                    return '<i class="fa-regular fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'label' => '<i class="' . $entityType->icon() . '" title="' . $entityType->plural() . '"></i>',
            'render' => function($model) {
                return number_format($model->children_count);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'races.index',
        'baseRoute' => 'races',
        'trans' => 'races.fields.',
    ]
) !!}
