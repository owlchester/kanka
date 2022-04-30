<?php
/** @var \App\Models\MapPoint $model */
/** @var \App\Models\Location $location */
$entityFieldStyle = !isset($model) || empty($model->target_entity_id) ? 'display: none' : '';
$nameFieldStyle = !isset($model) || empty($model->name) ? 'display: none' : '';

$colourOptions = [
    'grey' => __('colours.grey'),
    'red' => __('colours.red'),
    'blue' => __('colours.blue'),
    'green' => __('colours.green'),
    'yellow' => __('colours.yellow'),
    'black' => __('colours.black'),
    'white' => __('colours.white')
];

$iconOptions = __('locations.map.points.icons');
unset($iconOptions['pin']);
unset($iconOptions['entity']);

$shapeOptions = [
    \App\Models\MapPoint::SHAPE_CIRCLE => __('locations.map.points.shapes.circle'),
    \App\Models\MapPoint::SHAPE_SQUARE => __('locations.map.points.shapes.square'),
];


$sizeOptions = [
    \App\Models\MapPoint::SIZE_TINY => __('locations.map.points.sizes.tiny'),
    \App\Models\MapPoint::SIZE_SMALL => __('locations.map.points.sizes.small'),
    \App\Models\MapPoint::SIZE_STANDARD => __('locations.map.points.sizes.standard'),
    \App\Models\MapPoint::SIZE_LARGE => __('locations.map.points.sizes.large'),
    \App\Models\MapPoint::SIZE_HUGE => __('locations.map.points.sizes.huge'),
];
?>

<div class="location-map-errors text-red" style="display: none"></div>

<div class="phase-first" style="{{ isset($model) ? 'display: none' : '' }}">
    <p class="help-block">{{ __('locations.map.points.helpers.location_or_name') }}</p>
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="#" class="btn btn-app" id="phase-first-entity">
                <i class="fas fa-solid fa-search"></i>
                {{ __('crud.fields.entity') }}
            </a>
            <a href="#" class="btn btn-app" id="phase-first-label">
                <i class="fas fa-solid fa-comment-alt"></i>
                {{ __('locations.map.points.fields.name') }}
            </a>
        </div>
    </div>
</div>
<div class="phase-second" style="{{ !isset($model) ? 'display: none' : '' }}">
    <div class="row">
        <div class="col-sm-12 ">
            <div class="form-group required point-entity" style="{{ $entityFieldStyle }}">
                <a href="#" class="phase-undo pull-right"><i class="fa-solid fa-undo" title="{{ __('crud.actions.back') }}"></i></a>
                {!! Form::select2(
                    'target_entity_id',
                    (isset($model) && $model->targetEntity ? $model->targetEntity : null),
                    App\Models\Entity::class,
                    false,
                    'crud.fields.entity',
                    'search.entities-with-reminders',
                    'crud.placeholders.entity'
                ) !!}
            </div>
            <div class="form-group required point-label" style="{{ $nameFieldStyle }}">
                <a href="#" class="phase-undo pull-right"><i class="fa-solid fa-undo" title="{{ __('crud.actions.back') }}"></i></a>
                <label>{{ __('locations.map.points.fields.name') }}</label>
                {!! Form::text('name', (!isset($model) ? request()->get('name', null) : null), ['placeholder' => __('locations.map.points.placeholders.name'), 'class' => 'form-control', 'maxlength' => 194]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label>{{ __('locations.map.points.fields.colour') }}</label><br />
                {!! Form::text('colour', null, ['class' => 'form-control spectrum', 'maxlength' => 20] ) !!}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group required">
                <label>{{ __('locations.map.points.fields.icon') }}</label>
                <select name="icon" class="form-control select2-icon" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}">
                    <option value="pin" data-icon="fa-solid fa-map-marker">{{ __('locations.map.points.icons.pin') }}</option>
                    <option value="entity"@if (isset($model) && $model->icon == "entity") selected="selected" @endif>{{ __('locations.map.points.icons.entity') }}</option>
                    @foreach ($iconOptions as $icon => $text)
                    <option value="{{ $icon }}" @if (isset($model) && $model->icon == $icon) selected="selected" @endif>{{ $text }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group required">
                <label>{{ __('locations.map.points.fields.shape') }}</label>
                <select name="shape_id" class="form-control select2-shape" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}">
                    @foreach ($shapeOptions as $shape => $text)
                        <option value="{{ $shape }}" @if (isset($model) && $model->shape_id == $shape) selected="selected" @endif>{{ $text }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group required">
                <label>{{ __('locations.map.points.fields.size') }}</label>
                <select name="size_id" class="form-control select2-size" style="width: 100%" data-language="{{ LaravelLocalization::getCurrentLocale() }}">
                    @foreach ($sizeOptions as $size => $text)
                        <option value="{{ $size }}" @if ((isset($model) && $model->size_id == $size) || ($size == 'standard' && !isset($model))) selected="selected" @endif>{{ $text }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

{!! Form::hidden('location_id', $location->id) !!}
{!! Form::hidden('axis_x', (!isset($model) ? request()->get('axis_x', null) : null)) !!}
{!! Form::hidden('axis_y', (!isset($model) ? request()->get('axis_y', null) : null)) !!}

