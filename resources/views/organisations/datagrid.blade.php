<?php /** @var \App\Models\Organisation $model */ ?>
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
                return implode(', ', $locations);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-users" title="' . trans('organisations.fields.members') . '"></i>',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return number_format($model->members_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>',
            'field' => 'is_defunct',
            'render' => function($model) {
                if ($model->isDefunct()) {
                    return '<i class="fa-regular fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>';
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
        'route' => 'organisations.index',
        'baseRoute' => 'organisations',
        'trans' => 'organisations.fields.',
    ]
) !!}
