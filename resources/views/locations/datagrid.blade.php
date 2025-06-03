<?php /** @var \App\Models\Location $model */?>

{!! $datagrid
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        [
            'type' => 'parent',
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return number_format($model->characters_count);
                $total = $model->characters->count();
                foreach ($model->descendants()->with('characters')->get() as $child) {
                    $total += $child->characters->count();
                }
                return $total;
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-regular fa-building-circle-xmark" title="' . __('locations.fields.is_destroyed') . '"></i>',
            'field' => 'is_destroyed',
            'render' => function($model) {
                if ($model->isDestroyed()) {
                    return '<i class="fa-regular fa-building-circle-xmark" title="' . __('locations.fields.is_destroyed') . '"></i>';
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
        'route' => 'locations.index',
        'baseRoute' => 'locations',
        'trans' => 'locations.fields.',
    ]
) !!}
