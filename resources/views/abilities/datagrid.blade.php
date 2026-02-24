<?php /** @var \App\Models\Ability $model */ ?>
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
            'label' => '<i class="fa-regular fa-user" title="' . __('abilities.show.tabs.entities') . '"></i>',
            'render' => function($model) {
                return number_format($model->entity_abilities_count);
            },
            'disableSort' => true,
        ],
        [
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
    ->options([
        'route' => 'abilities.index',
        'baseRoute' => 'abilities',
        'trans' => 'abilities.fields.',
    ])
; !!}
