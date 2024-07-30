<x-grid>
    <x-forms.field
        field="weather"
        css="col-span-2"
        :required="true"
        :label="__('calendars/weather.fields.weather')">
        <x-forms.select name="weather" :options="__('calendars/weather.options.weather')" :selected="$model->weather ?? null" />
    </x-forms.field>

    <x-forms.field
        field="name"
        css="col-span-2"
        :label="__('calendars/weather.fields.name')">
        <input type="text" name="name" placeholder="{{ __('calendars/weather.placeholders.name') }}" maxlength="40" value="{!! htmlspecialchars(old('name', $source->name ?? $weather->name ?? null)) !!}" />
    </x-forms.field>

    <x-forms.field
        field="temperature"
        :label="__('calendars/weather.fields.temperature')">
        <input type="text" name="wind" value="{{ old('temperature', $weather->temperature ?? null) }}" placeholder="{{ __('calendars/weather.placeholders.temperature') }}" aria-label="{{ __('calendars/weather.placeholders.temperature') }}" maxlength="191" class="w-full" />
    </x-forms.field>

    <x-forms.field
        field="precipitation"
        :label="__('calendars/weather.fields.precipitation')">
        <input type="text" name="precipitation" value="{{ old('precipitation', $weather->precipitation ?? null) }}" placeholder="{{ __('calendars/weather.placeholders.precipitation') }}" aria-label="{{ __('calendars/weather.placeholders.precipitation') }}" maxlength="191" class="w-full" />
    </x-forms.field>

    <x-forms.field
        field="winds"
        :label="__('calendars/weather.fields.wind')">
        <input type="text" name="wind" value="{{ old('wind', $weather->wind ?? null) }}" placeholder="{{ __('calendars/weather.placeholders.wind') }}" aria-label="{{ __('calendars/weather.placeholders.wind') }}" maxlength="191" class="w-full" />
    </x-forms.field>

    <x-forms.field
        field="effect"
        :label="__('calendars/weather.fields.effect')">
        <input type="text" name="effect" value="{{ old('effect', $weather->effect ?? null) }}" placeholder="{{ __('calendars/weather.placeholders.effect') }}" aria-label="{{ __('calendars/weather.placeholders.effect') }}" maxlength="191" class="w-full" />
    </x-forms.field>

@include('cruds.fields.visibility_id', ['model' => $weather ?? null])
</x-grid>
