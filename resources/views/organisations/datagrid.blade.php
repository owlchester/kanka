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
            'render' => function($model) {
                $locations = [];
                foreach ($model->locations as $location) {
                    $locations[] = $location->tooltipedLink();
                }
                return implode( ', ', $locations);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . trans('organisations.fields.members') . '"></i>',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->members->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>',
            'field' => 'is_defunct',
            'render' => function($model) {
                if ($model->isDefunct()) {
                    return '<i class="fa-solid fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
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
