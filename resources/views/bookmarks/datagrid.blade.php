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
                    return '<i class="fa-regular fa-th-large"></i> ' . __('bookmarks.fields.dashboard');
                } elseif ($model->isEntity()) {
                    return '<i class="fa-regular fa-star"></i> ' . __('entities.entity');
                } elseif ($model->isList()) {
                    return '<i class="fa-regular fa-th-list"></i> ' . __('campaigns/categories.tab');
                } elseif ($model->isRandom()) {
                    return '<i class="fa-regular fa-question"></i> ' . __('dashboards/widgets/random.name');
                }
                return '';
            },
            'disableSort' => true,

        ],
        [
            'label' => __('bookmarks.fields.target'),
            'render' => function (\App\Models\Bookmark $model) {
                if ($model->isDashboard()) {
                    return $model->dashboard->name;
                } elseif ($model->isEntity()) {
                    if (!$model->target) {
                        return __('crud.users.unknown');
                    }
                    return '<a href="' . $model->target->url() . '" class="text-link">' . $model->target->name . '</a>';
                } elseif ($model->isList()) {
                    return $model->entityType->plural();
                } elseif ($model->isRandom()) {
                    return $model->random_entity_type == 'any' ? __('bookmarks.random_types.any') : $model->randomEntityType?->name();
                }
                return '';
            },
            'disableSort' => true,
        ],
        [
            'label' => __('bookmarks.fields.active'),
            'render' => function ($model) {
                if ($model->is_active) {
                    return '<i class="fa-regular fa-check-circle" aria-hidden="true"></i>';
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
