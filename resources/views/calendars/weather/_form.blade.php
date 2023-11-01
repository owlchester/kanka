{{ csrf_field() }}

<x-grid>
    <x-forms.field
        field="weather"
        css="col-span-2"
        :required="true"
        :label="__('calendars/weather.fields.weather')">
        {!! Form::select('weather', __('calendars/weather.options.weather'), null, ['class' => 'w-full']) !!}
    </x-forms.field>

    <x-forms.field
        field="name"
        css="col-span-2"
        :label="__('calendars/weather.fields.name')">
        {!! Form::text('name', null, ['class' => 'w-full', 'placeholder' => __('calendars/weather.placeholders.name'), 'maxlength' => 40]) !!}
    </x-forms.field>

    <x-forms.field
        field="temperature"
        :label="__('calendars/weather.fields.temperature')">
        {!! Form::text('temperature', null, ['class' => 'w-full', 'placeholder' => __('calendars/weather.placeholders.temperature')]) !!}
    </x-forms.field>

    <x-forms.field
        field="precipitation"
        :label="__('calendars/weather.fields.precipitation')">
        {!! Form::text('precipitation', null, ['class' => 'w-full', 'placeholder' => __('calendars/weather.placeholders.precipitation')]) !!}
    </x-forms.field>

    <x-forms.field
        field="winds"
        :label="__('calendars/weather.fields.wind')">
        {!! Form::text('wind', null, ['class' => 'w-full', 'placeholder' => __('calendars/weather.placeholders.wind')]) !!}
    </x-forms.field>

    <x-forms.field
        field="effect"
        :label="__('calendars/weather.fields.effect')">
        {!! Form::text('effect', null, ['class' => 'w-full', 'placeholder' => __('calendars/weather.placeholders.effect')]) !!}
    </x-forms.field>

@include('cruds.fields.visibility_id', ['model' => $weather ?? null])
</x-grid>
