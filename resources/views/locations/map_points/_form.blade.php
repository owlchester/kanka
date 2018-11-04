<p class="help-block">{{ trans('locations.map.points.helpers.location_or_name') }}</p>

<div class="location-map-errors text-red" style="display: none"></div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {!! Form::select2(
                'target_entity_id',
                (isset($model) && $model->targetEntity ? $model->targetEntity : null),
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.calendar_event',
                'crud.placeholders.entity'
            ) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.name') }}</label>
            {!! Form::text('name', (!isset($model) ? request()->get('name', null) : null), ['placeholder' => trans('locations.map.points.placeholders.name'), 'class' => 'form-control', 'maxlength' => 194]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.colour') }}</label>
            {!! Form::select('colour', [
                'grey' => trans('colours.grey'),
                'red' => trans('colours.red'),
                'blue' => trans('colours.blue'),
                'green' => trans('colours.green'),
                'yellow' => trans('colours.yellow'),
                'black' => trans('colours.black'),
                'white' => trans('colours.white')
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>

<?php
$iconOptions = trans('locations.map.points.icons');
unset($iconOptions['pin']);
unset($iconOptions['entity']);
$iconOptions = array_merge([
    'pin' => trans('locations.map.points.icons.pin'),
    'entity' => trans('locations.map.points.icons.entity'),
], $iconOptions);
?>
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.icon') }}</label>
            {!! Form::select('icon',
                $iconOptions
            , null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.shape') }}</label>
            {!! Form::select('shape', [
                'circle' => trans('locations.map.points.shapes.circle'),
                'square' => trans('locations.map.points.shapes.square'),
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.size') }}</label>
            {!! Form::select('size', [
                'standard' => trans('locations.map.points.sizes.standard'),
                'small' => trans('locations.map.points.sizes.small'),
                'large' => trans('locations.map.points.sizes.large')
            ], null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('location_id', $location->id) !!}
{!! Form::hidden('axis_x', (!isset($model) ? request()->get('axis_x', null) : null)) !!}
{!! Form::hidden('axis_y', (!isset($model) ? request()->get('axis_y', null) : null)) !!}