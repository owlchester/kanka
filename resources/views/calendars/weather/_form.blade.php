{{ csrf_field() }}
<div class="form-group required">
    <label>{{ trans('calendars/weather.fields.weather') }}</label>
    {!! Form::select('weather', __('calendars/weather.options.weather'), null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label>{{ trans('calendars/weather.fields.temperature') }}</label>
    {!! Form::text('temperature', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.temperature')]) !!}
</div>
<div class="form-group">
    <label>{{ trans('calendars/weather.fields.precipitation') }}</label>
    {!! Form::text('precipitation', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.precipitation')]) !!}
</div>
<div class="form-group">
    <label>{{ trans('calendars/weather.fields.wind') }}</label>
    {!! Form::text('wind', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.wind')]) !!}
</div>
<div class="form-group">
    <label>{{ trans('calendars/weather.fields.effect') }}</label>
    {!! Form::text('effect', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.effect')]) !!}
</div>

@include('cruds.fields.visibility')
