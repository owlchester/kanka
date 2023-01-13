<?php
/** @var \App\Models\MapMarker $model */
$campaign = \App\Facades\CampaignLocalization::getCampaign();

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
<div class="form-group">
    <label for="icon">{{ __('maps/markers.fields.icon') }}</label>
    {!! Form::select('icon', $iconOptions, null, ['class' => 'form-control', 'id' => 'icon']) !!}
</div>
@if ($campaign->boosted())
<div class="form-group">
    <label>{{ __('maps/markers.fields.custom_icon') }}</label>
        {!! Form::text(
            'custom_icon',
            null,
            [
                'class' => 'form-control',
                'placeholder' => __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-sword"']),
                'list' => 'map-marker-icon-list',
                'autocomplete' => 'off'
            ])
        !!}
</div>
<div class="hidden">
    <datalist id="map-marker-icon-list">
        @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
            <option value="{{ $icon }}">{{ $icon }}</option>
        @endforeach
    </datalist>
</div>
@endif
<div class="form-group">
    <label>{{ __('maps/markers.fields.font_colour') }}</label><br />
    {!! Form::text('font_colour', null, ['class' => 'form-control spectrum', 'maxlength' => 6] ) !!}
</div>
<div class="form-group">
    <label>
        {{ __('maps/markers.fields.is_draggable') }}
    </label>
    {{ Form::select('is_draggable',  $typeOptions, null, ['class' => 'form-control', 'id' => 'type_id']) }}
</div>
<div class="form-group">
    <label for="opacity">{{ __('maps/markers.fields.opacity') }}</label><br />
    {!! Form::number('opacity', (!empty($source) ? $source->opacity : (isset($model) ? $model->opacity : null)), ['class' => 'form-control', 'maxlength' => 3, 'step' => 10, 'max' => 100, 'min' => 0, 'id' => 'opacity'] ) !!}
</div>
<div class="form-group">
    <label>{{ __('locations.map.points.fields.colour') }}</label><br />
    {!! Form::text('colour', null, ['class' => 'form-control spectrum', 'maxlength' => 6] ) !!}
</div>
<div class="form-group">
    <label for="group_id">
        {{ __('maps/markers.fields.group') }}
    </label>
    {{ Form::select('group_id', $groups, null, ['class' => 'form-control', 'id' => 'group_id']) }}
</div>
<div class="form-group">
    @include('cruds.fields.visibility_id', ['bulk' => true])
</div>
