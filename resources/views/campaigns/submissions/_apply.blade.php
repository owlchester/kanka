<x-grid type="1/1">
    @include('partials.errors')

    <p class="text-neutral-content m-0">{{ __('campaigns/submissions.apply.help') }}</p>

    <x-forms.field field="application" :label="__('campaigns/submissions.fields.application')">
        <textarea name="application" class="w-full" rows="5" placeholder="{{ __('campaigns/submissions.placeholders.note') }}">{!! old('application', $submission->text ?? null) !!}</textarea>
    </x-forms.field>
</x-grid>
