<?php /** @var \App\Models\Bookmark $model */ ?>

{!! $datagrid
    ->columns([
        // Name
        'name',
        'position',
        [
            'label' => __('crud.fields.type'),
            'render' => function ($model) {
                if ($model->isDashboard()) {
                    return '<i class="fa-solid fa-th-large"></i> ' . __('bookmarks.fields.dashboard');
                } elseif ($model->isEntity()) {
                    return '<i class="fa-solid fa-star"></i> ' . __('bookmarks.fields.entity');
                } elseif ($model->isList()) {
                    return '<i class="fa-solid fa-th-list"></i> ' . __('bookmarks.fields.type');
                } elseif ($model->isRandom()) {
                    return '<i class="fa-solid fa-question"></i> ' . __('bookmarks.fields.random');
                }
                return '';
            },
            'disableSort' => true,

        ],
        [
            'label' => '',
            'render' => function ($model) {
                if ($model->isDashboard()) {
                    return '<a href="' . $model->getRoute() . '">' . $model->name . '</a>';
                } elseif ($model->isEntity()) {
                    if (!$model->target) {
                        return __('crud.users.unknown');
                    }
                    return '<a href="' . $model->getRoute() . '">' . $model->target->name . '</a>';
                } elseif ($model->isList()) {
                    return $model->entityType->plural();
                } elseif ($model->isRandom()) {
                    return $model->random_entity_type == 'any' ? __('bookmarks.random_types.any') : __('entities.' . $model->random_entity_type);
                }
                return '';
            },
            'disableSort' => true,
        ],
        [
            'label' => __('bookmarks.fields.active'),
            'render' => function ($model) {
                if ($model->is_active) {
                    return '<i class="fa-solid fa-check-circle" aria-hidden="true"></i>';
                }
                return '';
            },
            'field' => 'is_active',
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'bookmarks.index',
        'baseRoute' => 'bookmarks',
        'trans' => 'bookmarks.fields.',
        'disableEntity' => true,
    ]
) !!}
