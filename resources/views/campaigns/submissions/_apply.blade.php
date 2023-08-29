<x-grid type="1/1">
    @include('partials.errors')

    <p class="text-neutral-content m-0">{{ __('campaigns/submissions.apply.help') }}</p>

    <x-forms.field field="application" :label="__('campaigns/submissions.fields.application')">
        {!! Form::textarea('application', !empty($submission) ? $submission->text : null, [
            'class' => 'w-full', 'rows' => 5,
            'placeholder' => __('campaigns/submissions.placeholders.note')
        ]) !!}
    </x-forms.field>
</x-grid>
