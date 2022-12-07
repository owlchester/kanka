<div class="form-group required">
    <label>{{ __('crud.fields.entity_type') }}</label>
    {!! Form::select('entity_type', $entities, [], ['class' => 'form-control']) !!}
</div>
<div class="form-group required">
    <label>{{ __('entities/files.fields.file') }}    </label>

{!! Form::file('default_entity_image', ['class' => 'image form-control']) !!}
</div>
