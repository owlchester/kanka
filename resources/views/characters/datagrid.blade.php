<?php /** @var \App\Models\Character $model */?>

{!! $datagrid
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'title',
        'type',
        [
            'label' => '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '" aria-hidden="true"></i> <span class="sr-only">' . __('characters.fields.is_dead') . '</span>',
            'field' => 'is_dead',
            'render' => function($model) {
                if ($model->is_dead) {
                    return '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '" aria-hidden="true"></i>';
                }
                return '';
            },
            'class' => 'icon w-14'
        ],
        [
            'label' => __('entities.families'),
            'visible' => $campaign->enabled('families'),
            'disableSort' => true,
            'render' => function($model) {
                $families = [];
                foreach ($model->families as $family) {
                    $families[] = $family->tooltipedLink();
                }
                return implode( ', ', $families);
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('entities.races'),
            'visible' => $campaign->enabled('races'),
            'disableSort' => true,
            'render' => function($model) {
                $races = [];
                foreach ($model->races as $race) {
                    $races[] = $race->tooltipedLink();
                }
                return implode( ', ', $races);
            }
        ],
        [
            'type' => 'is_private',
        ],
        /*[
            'label' => '<i class="fa-solid fa-transgender-alt" title="' . __('characters.fields.sex') . '"></i>',
            'field' => 'sex',
        ],*/
    ])
    ->options([
        'route' => 'characters.index',
        'baseRoute' => 'characters',
        'trans' => 'characters.fields.',
    ]
) !!}
