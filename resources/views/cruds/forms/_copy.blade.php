<div class="form-group">
    {!! Form::hidden('copy_source_notes', null) !!}
    <label>{!! Form::checkbox('copy_source_notes', 1, false) !!}
        {{ trans('crud.fields.copy_notes') }}
    </label>
</div>
<input type="hidden" name="copy_source_id" value="{{ !empty($source) ? (!empty($source->entity) ? $source->entity->id : $source->id) : old('copy_source_id') }}">
