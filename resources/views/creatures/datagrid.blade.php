<?php /** @var \App\Models\Creature $model */ ?>
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
            'label' => \App\Facades\Module::plural(config('entities.ids.creature'), __('entities.creatures')),
            'render' => function($model) {
                return $model->children->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
            'render' => function($model) use ($campaign) {
                $locations = [];
                foreach ($model->locations as $location) {
                    if (!$location->entity) {
                        continue;
                    }
                    $locations[] = \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($location->entity, $campaign)
                );
                }
                return implode( ', ', $locations);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>',
            'field' => 'is_extinct',
            'render' => function($model) {
                if ($model->isExtinct()) {
                    return '<i class="fa-solid fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'label' => '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '"></i>',
            'field' => 'is_dead',
            'render' => function($model) {
                if ($model->isDead()) {
                    return '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'creatures.index',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
    ]
) !!}
