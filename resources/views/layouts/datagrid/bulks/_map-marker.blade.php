<?php
/** @var \App\Models\MapMarker $model */

$iconOptions = [
    '' => null,
    1 => __('maps/markers.icons.marker'),
    2 => __('maps/markers.icons.question'),
    3 => __('maps/markers.icons.exclamation'),
    4 => __('maps/markers.icons.entity'),
];

$sizeOptions = [
    '' => null,
    1 => __('maps/markers.circle_sizes.tiny'),
    2 => __('maps/markers.circle_sizes.small'),
    3 => __('maps/markers.circle_sizes.standard'),
    4 => __('maps/markers.circle_sizes.large'),
    5 => __('maps/markers.circle_sizes.huge'),
    6 => __('maps/markers.circle_sizes.custom'),
];

$groups = $model->groupOptions();
$groups[-1] = __('crud.filters.options.none');
?>
<x-grid>
    <x-forms.field field="icon" :label="__('maps/markers.fields.icon')">
        <x-forms.select name="icon" :options="$iconOptions" class="w-full" id="icon" />
    </x-forms.field>

    @if ($campaign->boosted())
    <x-forms.field field="custom-icon" :label="__('maps/markers.fields.custom_icon')">

        <input type="text" name="custom_icon" value="{{ old('custom_icon', $model->custom_icon ?? null) }}" class="w-full" placeholder="{{ __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-sword"']) }}" autocomplete="off" list="map-marker-icon-list" />

        <div class="hidden">
            <datalist id="map-marker-icon-list">
                @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
    </x-forms.field>
    @endif
    @include('maps.markers.fields.font_colour', ['dropdownParent' => '#primary-dialog'])

    @include('cruds.fields.draggable_choice')

    <x-forms.field field="opacity" :label="__('maps/markers.fields.opacity')">
        <input type="number" name="opacity" class="w-full" value="{{ $source->opacity ?? old('opacity', $model->opacity ?? null) }}" min="0" step="10" max="100" id="opacity" maxlength="3" />
    </x-forms.field>

    @include('maps.markers.fields.background_colour', ['dropdownParent' => '#primary-dialog'])

    <x-forms.field field="group" :label="__('maps/markers.fields.group')">
        <x-forms.select name="group_id" :options="$groups" class="w-full" />
    </x-forms.field>
    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
