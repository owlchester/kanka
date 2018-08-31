{{ csrf_field() }}
<p class="help-block">{{ trans('locations.map.points.helpers.location_or_name') }}</p>

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
<hr />
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.axis_x') }}</label>
            {!! Form::number('axis_x', (!isset($model) ? request()->get('axis_x', null) : null), ['placeholder' => trans('locations.map.points.placeholders.axis_x'), 'class' => 'form-control', 'maxlength' => 6]) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            <label>{{ trans('locations.map.points.fields.axis_y') }}</label>
            {!! Form::number('axis_y', (!isset($model) ? request()->get('axis_y', null) : null), ['placeholder' => trans('locations.map.points.placeholders.axis_y'), 'class' => 'form-control', 'maxlength' => 6]) !!}
        </div>
    </div>
</div>
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

{!! Form::hidden('location_id', $location->id) !!}