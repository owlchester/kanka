<?php /** @var \App\Models\Relation $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->service($filterService)
    ->models($models)
    ->columns([
        [
            'field' => 'entity_id',
            'label' => __('crud.fields.entity'),
            'class' => null,
            'render' => function($model) {
                return $model->entity->tooltipedLink();
            }
        ],
        [
            'field' => 'created_by',
            'label' => __('campaigns.members.fields.name'),
            'class' => null,
            'render' => function($model) {
                return $model->user?->name;
            }
        ],
        [
            'field' => 'created_at',
            'label' => __('history.fields.created_at'),
            'render' => function($model) {
                return $model->created_at->diffForHumans();
            }
        ],
    ])
    ->options(    [
        'route' => 'history.index',
        'baseRoute' => 'history',
        'disableEntity' => true,
    ]
) !!}
