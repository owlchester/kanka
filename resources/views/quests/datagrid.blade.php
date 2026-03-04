<?php /** @var \App\Models\Quest $model */ ?>

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
            'field' => 'instigator.name',
            'label' => __('quests.fields.instigator'),
            'render' => function($model) use ($campaign) {
                if (!$model->instigator) {
                    return '';
                }
                return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->instigator, $campaign)
                );
            },
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('quests.show.tabs.elements'),
            'render' => function($model) {
                return number_format($model->elements_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-check-circle" title="' . __('quests.fields.is_completed') . '"></i>',
            'render' => function ($model) {
                if ($model->isOngoing()) {
                    return '<i class="fa-regular fa-hourglass" title="' . __('quests.status.ongoing') . '"></i>';
                } elseif ($model->isCompleted()) {
                    return '<i class="fa-regular fa-check-circle" title="' . __('quests.status.completed') . '"></i>';
                } elseif ($model->isAbandoned()) {
                    return '<i class="fa-regular fa-ban" title="' . __('quests.status.abandoned') . '"></i>';
                }
                return null;
            },
            'field' => 'is_completed',
        ],
        [
            'type' => 'reminder',
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
        'route' => 'quests.index',
        'baseRoute' => 'quests',
        'trans' => 'quests.fields.',
    ]
) !!}
