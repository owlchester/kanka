<?php /** @var \App\Models\Family $model */ ?>

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
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-regular fa-users" title="' . __('organisations.fields.members') . '"></i>',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return number_format($model->members_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-skull" title="' . __('creatures.fields.is_extinct') . '"></i>',
            'field' => 'is_extinct',
            'render' => function($model) {
                if ($model->isExtinct()) {
                    return '<i class="fa-regular fa-skull" title="' . __('creatures.fields.is_extinct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],[
            'label' => '<i class="' . $entityType->icon() . '" title="' . $entityType->plural() . '" aria-hidden="true"></i>',
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
        'route' => 'families.index',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
    ]
) !!}
