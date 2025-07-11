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
                return number_format($model->entities_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="' . \App\Facades\Module::duoIcon('ability') . '" title="' . \App\Facades\Module::plural(config('entities.ids.ability'), __('entities.abilities')) . '"></i>',
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
