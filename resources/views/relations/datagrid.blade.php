<?php /** @var \App\Models\Relation $model */?>

{!! $datagrid
    ->columns([
        [
            'field' => 'owner_id',
            'label' => __('entities/relations.fields.owner'),
            'class' => null,
            'render' => function(\App\Models\Relation $model) use ($campaign) {
                return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->owner, $campaign)
                );
            }
        ],
        [
            'field' => 'target_id',
            'label' => __('entities/relations.fields.target'),
            'class' => null,
            'render' => function(\App\Models\Relation$model)  use($campaign) {
                return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->target, $campaign)
                );
            }
        ],
        [
            'field' => 'relation',
            'label' => __('entities/relations.fields.relation'),
            'render' => function(\App\Models\Relation$model) {
                if (empty($model->colour)) {
                    return $model->relation;
                }
                $html = '<div class="flex items-center gap-1">';
                $colour = '<div class="flex-0 w-5 h-5 inline-block rounded-2xl items-center justify-center" style="background-color: ' . $model->colour . '; "></div>';
                return $html . $colour . '<div class="grow">' . $model->relation . '</div></div>';
            }
        ],
        [
            'field' => 'mirror_id',
            'label' => '<i class="fa-solid fa-link" data-toggle="tooltip" data-title="' . __('entities/relations.hints.mirrored.title') . '" aria-hidden="true"></i>',
            'render' => function (\App\Models\Relation$model) {
                return $model->isMirrored() ? '<i class="fa-solid fa-link" aria-hidden="true" data-toggle="tooltip" data-title="' . __('entities/relations.hints.mirrored.title') . '"></i>' : null;
            }
        ],
        [
            'field' => 'is_pinned',
            'label' => '<i class="fa-solid fa-star" title="' . __('entities/relations.fields.is_star') . '"></i>',
            'render' => function (\App\Models\Relation$model) {
                return $model->isPinned() ? '<i class="fa-solid fa-star"></i>' : null;
            }
        ],
        [
            'field' => 'attitude',
            'label' => __('entities/relations.fields.attitude'),
        ],
        [
            'field' => 'visibility_id',
            'label' => __('crud.fields.visibility'),
            'render' => function (\App\Models\Relation$model) {
                return view('icons.visibility', ['icon' => $model->visibilityIcon()]);
            }
        ],
    ])
    ->options(    [
        'route' => 'relations.index',
        'baseRoute' => 'relations',
        'trans' => 'relations.fields.',
        'disableEntity' => true,
    ]
) !!}
