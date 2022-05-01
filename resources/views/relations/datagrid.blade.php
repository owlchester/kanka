<?php /** @var \App\Models\Relation $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        [
            'field' => 'owner_id',
            'label' => __('entities/relations.fields.owner'),
            'class' => null,
            'render' => function($model) {
                return '<a href="' . $model->owner->url() . '">' . $model->owner->name . '</a>';
            }
        ],
        [
            'field' => 'target_id',
            'label' => __('entities/relations.fields.target'),
            'class' => null,
            'render' => function($model) {
                return '<a href="' . $model->target->url() . '">' . $model->target->name . '</a>';
            }
        ],
        [
            'field' => 'relation',
            'label' => __('entities/relations.fields.relation'),
            'render' => function($model) {
                $colour = null;
                if (!empty($model->colour)) {
                    $colour = '<div class="label-tag-bubble" style="background-color: ' . $model->colour . '; "></div> ';
                }
                return $colour . $model->relation;
            }
        ],
        [
            'field' => 'mirror_id',
            'label' => '<i class="fa-solid fa-sync-alt" title="' . __('entities/relations.hints.mirrored.title') . '"></i>',
            'render' => function ($model) {
                return $model->mirrored() ? '<i class="fa-solid fa-sync-alt"></i>' : null;
            }
        ],
        [
            'field' => 'is_star',
            'label' => '<i class="fa-solid fa-star" title="' . __('entities/relations.fields.is_star') . '"></i>',
            'render' => function ($model) {
                return $model->is_star ? '<i class="fa-solid fa-star"></i>' : null;
            }
        ],
        [
            'field' => 'attitude',
            'label' => __('entities/relations.fields.attitude'),
        ],
        [
            'type' => 'is_private',
        ],
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'relations.index',
        'baseRoute' => 'relations',
        'trans' => 'relations.fields.',
        'campaign' => $campaign,
        'disableEntity' => true,
    ]
) !!}
