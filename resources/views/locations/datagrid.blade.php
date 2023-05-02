<?php /** @var \App\Models\Location $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->service($filterService)
    ->models($models)
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        [
            'label' => __('crud.fields.parent'),
            'field' => 'parentLocation.name',
            'render' => function($model) {
                if ($model->parentLocation) {
                return $model->parentLocation->tooltipedLink();
                }
            }
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
            'visible' => $campaignService->enabled('characters'),
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
