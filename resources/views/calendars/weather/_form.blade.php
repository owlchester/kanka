{{ csrf_field() }}

<x-grid>
    <div class="field-weather col-span-2 required">
        <label>{{ __('calendars/weather.fields.weather') }}</label>
        {!! Form::select('weather', __('calendars/weather.options.weather'), null, ['class' => 'form-control']) !!}
    </div>
    <div class="field-name col-span-2">
        <label>{{ __('calendars/weather.fields.name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.name'), 'maxlength' => 40]) !!}
    </div>
    <div class="field-temperature">
        <label>{{ __('calendars/weather.fields.temperature') }}</label>
        {!! Form::text('temperature', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.temperature')]) !!}
    </div>

    <div class="field-precipitation">
        <label>{{ __('calendars/weather.fields.precipitation') }}</label>
        {!! Form::text('precipitation', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.precipitation')]) !!}
    </div>

    <div class="field-winds">
        <label>{{ __('calendars/weather.fields.wind') }}</label>
        {!! Form::text('wind', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.wind')]) !!}
    </div>

    <div class="field-effect">
        <label>{{ __('calendars/weather.fields.effect') }}</label>
        {!! Form::text('effect', null, ['class' => 'form-control', 'placeholder' => __('calendars/weather.placeholders.effect')]) !!}
    </div>

@include('cruds.fields.visibility_id', ['model' => $weather ?? null])
</x-grid>
