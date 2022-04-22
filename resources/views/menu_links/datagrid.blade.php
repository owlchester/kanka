<?php /** @var \App\Models\MenuLink $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
        'position',
        [
            'label' => __('crud.fields.type'),
            'render' => function ($model) {
                if ($model->isDashboard()) {
                    return '<i class="fa-solid fa-th-large"></i> ' . __('menu_links.fields.dashboard');
                } elseif ($model->isEntity()) {
                    return '<i class="ra ra-tower"></i> ' . __('menu_links.fields.entity');
                } elseif ($model->isList()) {
                    return '<i class="fa-solid fa-th-list"></i> ' . __('menu_links.fields.type');
                } elseif ($model->isRandom()) {
                    return '<i class="fa-solid fa-question"></i> ' . __('menu_links.fields.random');
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
                    return '<a href="' . $model->target->url() . '">' . $model->target->name . '</a>';
                } elseif ($model->isList()) {
                    return __('entities.' . $model->type);
                } elseif ($model->isRandom()) {
                    return $model->random_entity_type == 'any' ? __('menu_links.random_types.any') : __('entities.' . $model->random_entity_type);
                }
                return '';
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
        'route' => 'menu_links.index',
        'baseRoute' => 'menu_links',
        'trans' => 'menu_links.fields.',
        'campaign' => $campaign,
        'disableEntity' => true,
    ]
) !!}
