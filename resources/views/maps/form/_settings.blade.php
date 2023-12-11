<?php
/** @var Map $model */
use App\Models\Map;
$minInitial = Map::MIN_ZOOM;
$maxInitial = Map::MAX_ZOOM_REAL;
$defaultInitial = 0;

if (isset($model) && $model->isChunked()) {
    $minInitial = Map::MIN_ZOOM_CHUNK;
    $maxInitial = Map::MAX_ZOOM_CHUNK;
    $defaultInitial = $minInitial;
}
?>
<x-grid>
    <x-forms.field
        field="real"
        :label="__('maps.fields.is_real')">
        <input type="hidden" name="is_real" value="0" />
        <x-checkbox :text="__('maps.helpers.is_real')">
            {!! Form::checkbox('is_real') !!}
        </x-checkbox>
    </x-forms.field>

    <x-forms.field
        field="clustering"
        :label="__('maps.fields.has_clustering')">
        <input type="hidden" name="has_clustering" value="0" />
        <x-checkbox :text="__('maps.helpers.has_clustering')">
            {!! Form::checkbox('has_clustering', 1, !isset($model) ? true : $model->has_clustering) !!}
        </x-checkbox>
    </x-forms.field>

    <hr class="m-0 col-span-2"/>

@if (isset($model) && $model->isChunked())
    <x-alert type="info">
        <p>{{ __('maps.helpers.chunked_zoom') }}</p>
    </x-alert>
@else
    <x-forms.field
        field="max-zoom"
        :label="__('maps.fields.max_zoom')"
        :helper="__('maps.helpers.max_zoom', ['max' => Map::MAX_ZOOM, 'default' => 5])">
        {!! Form::number(
        'max_zoom',
        FormCopy::field('max_zoom')->string(),
        [
        'placeholder' => 5,
        'class' => '',
        ]
        ) !!}
    </x-forms.field>

    <x-forms.field
        field="min-zoom"
        :label="__('maps.fields.min_zoom')"
        :helper="__('maps.helpers.min_zoom', ['min' => Map::MIN_ZOOM, 'default' => -2])"
    >
        {!! Form::number(
        'min_zoom',
        FormCopy::field('min_zoom')->string(),
        [
        'placeholder' => -2,
        'class' => '',
        ]
        ) !!}
    </x-forms.field>
@endif

    <x-forms.field
        field="initial-zoom"
        :label="__('maps.fields.initial_zoom')"
        :helper=" __('maps.helpers.initial_zoom', ['min' => $minInitial, 'max' => $maxInitial, 'default' => $defaultInitial])">
        {!! Form::number(
        'initial_zoom',
        FormCopy::field('initial_zoom')->string(),
        [
        'placeholder' => 5,
        'class' => '',
        ]
        ) !!}
    </x-forms.field>

    <x-forms.field
        field="grid"
        :label="__('maps.fields.grid')"
        :helper=" __('maps.helpers.grid')">
        {!! Form::number(
        'grid',
        FormCopy::field('grid')->string(),
        [
        'placeholder' => __('maps.placeholders.grid'),
        'class' => '',
        'maxlength' => 4
        ]
        ) !!}
    </x-forms.field>

    <hr class="col-span-2 m-0" />

    <x-forms.field
        field="distance-name"
        :label="__('maps.fields.distance_name')">
        {!! Form::text(
            'config[distance_name]',
            FormCopy::field('config[distance_name]')->string(),
            [
                'placeholder' => __('maps.placeholders.distance_name'),
                'class' => '',
                'maxlength' => 20
            ]
            ) !!}
    </x-forms.field>

    <x-forms.field
        field="distance-measure"
        :label="__('maps.fields.distance_measure')"
        :tooltip="true"
        :helper="__('maps.helpers.distance_measure') . ' ' . __('maps.helpers.distance_measure_2')"
        >
        {!! Form::number(
        'config[distance_measure]',
        FormCopy::field('config[distance_measure]')->string(),
        [
            'class' => '',
            'min' => 0.0001,
            'max' => 100.99,
            'step' => 0.0001,
        ]
        ) !!}
    </x-forms.field>

    <hr class="col-span-2 m-0" />

    <x-forms.field field="centering col-span-2" :label="__('maps.fields.centering') ">
        <p class="text-neutral-content">
            {{ __('maps.helpers.centering') }}
        </p>

        <div class="nav-tabs-custom">
            <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
                <li class="active rounded">
                    <a data-toggle="tab" href="#coordinates">
                        {{ __('maps.fields.tabs.coordinates') }}
                    </a>
                </li>
                <li class="{{ (isset($model) && !empty($model))? '' : 'disabled cursor-' }}">
                    <a class="{{ (isset($model) && !empty($model))? '' : 'cursor-none' }}" data-toggle="tab"
                        href="#marker">
                        {{ __('maps.fields.tabs.marker') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-base-100 p-4">
                <div id="coordinates" class="tab-pane fade in active">
                    <x-helper  :text="__('maps.helpers.center')" />
                    <x-grid>
                        <x-forms.field field="center-y" :label="__('maps.fields.center_y')">
                            {!! Form::number(
                            'center_y',
                            FormCopy::field('center_y')->string(),
                            [
                            'placeholder' => __('maps.placeholders.center_y'),
                            'class' => '',
                            'min' => -90,
                            'step' => 0.001
                            ]
                            ) !!}
                        </x-forms.field>

                        <x-forms.field field="center-x" :label="__('maps.fields.center_x')">
                            {!! Form::number(
                            'center_x',
                            FormCopy::field('center_x')->string(),
                            [
                            'placeholder' => __('maps.placeholders.center_x'),
                            'class' => '',
                            'min' => -180,
                            'step' => 0.001
                            ]
                            ) !!}
                        </x-forms.field>
                    </x-grid>
                </div>
                <div id="marker" class="tab-pane fade">
                    @if (isset($model) && !empty($model))
                    <?php
                        //get the current center marker or null
                        $preset = null;
                        if (isset($model) && $model->center_marker) {
                            $preset = $model->center_marker;
                        }
                    ?>
                    <x-forms.foreign
                        name="center_marker_id"
                        :label="__('maps.fields.center_marker')"
                        :placeholder="__('maps.placeholders.center_marker')"
                        :allowClear="true"
                        :route="route('markers.find', [$campaign, 'include' => $model->id])"
                        :selected="$preset">
                    </x-forms.foreign>
                    @else
                        <p class="text-neutral-content">
                            Add markers to the map first.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </x-forms.field>
</x-grid>
