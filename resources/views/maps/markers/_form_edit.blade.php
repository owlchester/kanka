<?php
/** @var \App\Models\MapMarker $model */

$sizeOptions = [
    1 => __('maps/markers.circle_sizes.tiny'),
    2 => __('maps/markers.circle_sizes.small'),
    3 => __('maps/markers.circle_sizes.standard'),
    4 => __('maps/markers.circle_sizes.large'),
    5 => __('maps/markers.circle_sizes.huge'),
    6 => __('maps/markers.circle_sizes.custom'),
];
?>

<div id="marker-shape-fields" class="flex flex-col gap-5 w-full">
    @if ($model->isLabel())
        <x-helper>
            <p>{{ __('maps/markers.helpers.label') }}</p>
        </x-helper>
    @elseif ($model->isCircle())
        <x-grid>
            <x-forms.field field="size" :label="__('maps/markers.fields.size')">
                <x-forms.select name="size_id" :options="$sizeOptions" :selected="$model->size_id ?? null" id="size_id" />
            </x-forms.field>

            <x-forms.field field="radius" :label="__('maps/markers.fields.circle_radius')">
                <input type="text" name="circle_radius" value="{{ old('circle_radius', $model->circle_radius ?? null) }}" class="w-full map-marker-circle-radius" id="circle_radius" />
                <div class="map-marker-circle-helper">
                    <x-helper>
                        <p>{{ __('maps/markers.helpers.custom_radius') }}</p>
                    </x-helper>
                </div>
            </x-forms.field>
        </x-grid>
    @elseif ($model->isPolygon())
        <x-grid>
            <div class="field field-shape flex flex-col gap-2 col-span-2">
                @if ($campaign->boosted())
                    <div class="flex">
                        <div class="grow field">
                            <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                            <x-helper>
                                <p>{{ __('maps/markers.helpers.polygon.edit') }}</p>
                            </x-helper>
                        </div>
                        <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm">
                            <x-icon class="fa-regular fa-eraser" />
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{{ old('custom_shape', $model->custom_shape ?? null) }}</textarea>
                @else
                    <x-premium-cta :campaign="$campaign">
                        <p>{{ __('maps/markers.pitches.poly') }}</p>
                    </x-premium-cta>
                @endif
            </div>

            <x-forms.field field="stroke" :label="__('maps/markers.fields.polygon_style.stroke')">
                <span>
                <input type="text" name="polygon_style[stroke]" value="{{ old('polygon_style[stroke]', $model->polygon_style['stroke'] ?? null) }}" class="w-full spectrum" maxlength="7" data-append-to="#marker-modal" />
                </span>
            </x-forms.field>

            <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                <input type="number" name="polygon_style[stroke-width]" value="{{ old('polygon_style[stroke-width]', $model->polygon_style['stroke-width'] ?? null) }}" id="stroke-width" step="1" min="0" max="99" maxlength="2" />
            </x-forms.field>

            <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                <input type="number" name="polygon_style[stroke-opacity]" value="{{ old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
            </x-forms.field>
        </x-grid>
    @elseif ($model->isPath())
        <x-grid>
            @if ($campaign->boosted())
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                    <x-helper>
                        <p>{{ __('maps/markers.helpers.path.edit') }}</p>
                    </x-helper>
                    <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{{ old('custom_shape', $model->custom_shape ?? null) }}</textarea>
                </div>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    <input type="number" name="polygon_style[stroke-width]" value="{{ $model->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]') }}" id="path-stroke-width" step="1" min="1" max="99" maxlength="2" />
                </x-forms.field>
            @else
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <x-premium-cta :campaign="$campaign">
                        <p>{{ __('maps/markers.pitches.path') }}</p>
                    </x-premium-cta>
                </div>
            @endif
        </x-grid>
    @else
        <x-grid>
            @include('maps.markers.fields.icon')
            @include('maps.markers.fields.custom_icon')

            @include('maps.markers.fields.pin_size')
            @include('maps.markers.fields.font_colour')

            <x-forms.field field="draggable" css="" :label="__('maps/markers.fields.is_draggable')">
                <input type="hidden" name="is_draggable" value="0" />
                <x-checkbox :text="__('maps/markers.helpers.draggable')">
                    <input type="checkbox" name="is_draggable" value="1" @if (old('is_draggable', $model->is_draggable ?? false)) checked="checked" @endif />
                </x-checkbox>
            </x-forms.field>
        </x-grid>
    @endif
</div>

@include('maps.markers._form_common_fields')

<input type="hidden" name="shape_id" value="{{ $model->shape_id }}" />
@if (isset($from))
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
@include('editors.editor')
