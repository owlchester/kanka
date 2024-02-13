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

$typeOptions = [
    '' => null,
    0 => __('general.no'),
    1 => __('general.yes'),
];

$groups = $model->groupOptions();
$groups[-1] = __('crud.filters.options.none');
?>
<x-grid>
    <x-forms.field field="icon" :label="__('maps/markers.fields.icon')">
        {!! Form::select('icon', $iconOptions, null, ['class' => '', 'id' => 'icon']) !!}
    </x-forms.field>

    @if ($campaign->boosted())
    <x-forms.field field="custom-icon" :label="__('maps/markers.fields.custom_icon')">
        {!! Form::text(
            'custom_icon',
            null,
            [
                'class' => '',
                'placeholder' => __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-sword"']),
                'list' => 'map-marker-icon-list',
                'autocomplete' => 'off'
            ])
        !!}

        <div class="hidden">
            <datalist id="map-marker-icon-list">
                @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
    </x-forms.field>
    @endif
    <x-forms.field field="font-colour" :label="__('maps/markers.fields.font_colour')">
        {!! Form::text('font_colour', null, ['class' => ' spectrum', 'maxlength' => 6, 'data-append-to' => '#primary-dialog'] ) !!}
    </x-forms.field>

    <x-forms.field field="is-draggable" :label="__('maps/markers.fields.is_draggable')">
        {{ Form::select('is_draggable',  $typeOptions, null, ['class' => '', 'id' => 'type_id']) }}
    </x-forms.field>

    <x-forms.field field="opacity" :label="__('maps/markers.fields.opacity')">
        {!! Form::number('opacity', (!empty($source) ? $source->opacity : (isset($model) ? $model->opacity : null)), ['class' => '', 'maxlength' => 3, 'step' => 10, 'max' => 100, 'min' => 0, 'id' => 'opacity'] ) !!}
    </x-forms.field>

    <x-forms.field field="bg-colour" :label="__('maps/markers.fields.bg_colour')">
        {!! Form::text('colour', null, ['class' => ' spectrum', 'maxlength' => 6, 'data-append-to' => '#primary-dialog'] ) !!}
    </x-forms.field>

    <x-forms.field field="group" :label="__('maps/markers.fields.group')">
        {{ Form::select('group_id', $groups, null, ['class' => '', 'id' => 'group_id']) }}
    </x-forms.field>
    @include('cruds.fields.visibility_id', ['bulk' => true])
</x-grid>
