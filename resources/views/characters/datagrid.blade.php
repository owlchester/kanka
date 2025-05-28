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
            'label' => '<i class="fa-regular fa-skull" title="' . __('characters.fields.is_dead') . '" aria-hidden="true"></i> <span class="sr-only">' . __('characters.fields.is_dead') . '</span>',
            'field' => 'is_dead',
            'render' => function($model) {
                if ($model->is_dead) {
                    return '<i class="fa-regular fa-skull" data-toggle="tooltip" data-title="' . __('characters.hints.is_dead') . '" aria-hidden="true"></i> <span class="sr-only">' . __('characters.fields.is_dead') . '</span>';
                }
                return '';
            },
            'class' => 'icon w-14'
        ],
        [
            'label' => __('entities.families'),
            'visible' => $campaign->enabled('families'),
            'disableSort' => true,
            'render' => function ($model) use ($campaign) {
                $families = [];
                foreach ($model->characterFamilies as $family) {
                    if (!$family->family || !$family->family->entity) {
                        continue;
                    }
                    $families[] = \Illuminate\Support\Facades\Blade::renderComponent(
                        new \App\View\Components\EntityLink($family->family->entity, $campaign)
                    );
                }
                return implode(', ', $families);
            },
            ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('entities.races'),
            'visible' => $campaign->enabled('races'),
            'disableSort' => true,
            'render' => function($model) use ($campaign) {
                $races = [];
                foreach ($model->characterRaces as $race) {
                    if (!$race->race || !$race->race->entity) {
                        continue;
                    }
                    $races[] = \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($race->race->entity, $campaign)
                );
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
