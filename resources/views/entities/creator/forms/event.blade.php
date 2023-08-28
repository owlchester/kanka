<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])

    <x-forms.field
        field="date"
        :label="__('events.fields.date')">
        {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => __('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </x-forms.field>

    @include('cruds.fields.location')
</x-grid>
