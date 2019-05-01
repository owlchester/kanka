<div class="form-group">
    {!! Form::hidden('copy_source_attributes', null) !!}
    <label>{!! Form::checkbox('copy_source_attributes', 1, false) !!}
        {{ trans('crud.fields.copy_attributes') }}
    </label>
</div>

<div class="form-group">
    {!! Form::hidden('copy_source_notes', null) !!}
    <label>{!! Form::checkbox('copy_source_notes', 1, false) !!}
        {{ trans('crud.fields.copy_notes') }}
    </label>
</div>
<input type="hidden" name="copy_source_id" value="{{ !empty($source) ? $source->entity->id : old('copy_source_id') }}">