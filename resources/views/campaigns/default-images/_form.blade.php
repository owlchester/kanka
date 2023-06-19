<x-grid type="1/1">
    <div class="field-entity-type required">
        <label>{{ __('crud.fields.entity_type') }}</label>
        {!! Form::select('entity_type', $entities, [], ['class' => 'form-control']) !!}
    </div>
    <div class="field-file required">
        <label>{{ __('entities/files.fields.file') }}    </label>

    {!! Form::file('default_entity_image', ['class' => 'image form-control']) !!}
    </div>
</x-grid>
