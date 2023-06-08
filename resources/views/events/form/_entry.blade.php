<x-grid>
    @include('cruds.fields.name', ['trans' => 'events'])
    @include('cruds.fields.type', ['base' => \App\Models\Event::class, 'trans' => 'events'])

    @include('cruds.fields.event', ['isParent' => true])
    @include('cruds.fields.location')

    <div class="field-date">
        <label>
            {{ __('events.fields.date') }}
        </label>
        {!! Form::text('date', FormCopy::field('date')->string(), ['placeholder' => __('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        <p class="help-block">{{ __('events.helpers.date') }}</p>
    </div>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
