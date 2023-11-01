<x-grid>
    @include('cruds.fields.name', ['trans' => 'events'])
    @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])

    @include('cruds.fields.event', ['isParent' => true])
    @include('cruds.fields.location')

    <x-forms.field field="date" :label="__('events.fields.date')" :helper="__('events.helpers.date')">
        {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => __('events.placeholders.date'), 'class' => '', 'maxlength' => 191]) !!}
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
@include('cruds.forms._calendar', ['source' => $source])
