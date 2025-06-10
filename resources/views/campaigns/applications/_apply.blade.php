<x-grid type="1/1">
    @include('partials.errors')

    <p class="text-neutral-content m-0">{{ __('campaigns/applications.apply.help') }}</p>

    <x-forms.field field="application" :label="__('campaigns/applications.fields.application')">
        <textarea name="application" class="w-full" rows="5" placeholder="{{ __('campaigns/applications.placeholders.note') }}">{!! old('application', $application->text ?? null) !!}</textarea>
    </x-forms.field>
</x-grid>
