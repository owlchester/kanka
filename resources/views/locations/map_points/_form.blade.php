<p class="help-block">{{ trans('locations.map.points.helpers.location_or_name') }}</p>

<div class="location-map-errors text-red" style="display: none"></div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {!! Form::select2(
                'target_id',
                (isset($model) && $model->target ? $model->target : null),
                App\Models\Location::class,
                false,
                'locations.fields.location',
                'locations.find',
                'locations.placeholders.location'
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
        <div class="form-group">
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
</div>

{!! Form::hidden('location_id', $location->id) !!}
{!! Form::hidden('axis_x', (!isset($model) ? request()->get('axis_x', null) : null)) !!}
{!! Form::hidden('axis_y', (!isset($model) ? request()->get('axis_y', null) : null)) !!}