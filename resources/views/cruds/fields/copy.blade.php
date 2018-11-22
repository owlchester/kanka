@if (!empty($source) || !empty(old('copy_source_id')))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-copy"></i> {{ trans('crud.forms.copy_options') }}</h4>
        </div>
        <div class="panel-body">
            <div class="form-group">
                {!! Form::hidden('copy_source_attributes', null) !!}
                <label>{!! Form::checkbox('copy_source_attributes', 1, false) !!}
                    {{ trans('crud.fields.copy_attributes') }}
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="copy_source_id" value="{{ !empty($source) ? $source->entity->id : old('copy_source_id') }}">
@endif