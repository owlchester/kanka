{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('characters.attributes.fields.attribute') }}</label>
            {!! Form::text('attribute', null, ['placeholder' => trans('characters.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('characters.attributes.fields.value') }}</label>
            {!! Form::text('value', null, ['placeholder' => trans('characters.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('is_private', 0) !!}
            <label>{!! Form::checkbox('is_private') !!}
                {{ trans('characters.attributes.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('characters.attributes.hints.is_private') }}</p>
        </div>
    </div>
</div>

{!! Form::hidden('character_id', $parent->id) !!}