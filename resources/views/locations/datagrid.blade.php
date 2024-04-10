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
                $total = $model->characters->count();
                foreach ($model->descendants()->with('characters')->get() as $child) {
                    $total += $child->characters->count();
                }
                return $total;
            },
            'disableSort' => true,
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
