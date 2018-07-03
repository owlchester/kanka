@if (empty($model))
    <div class="form-group">
        <label>{{ trans('crud.attributes.fields.template') }}</label>
        {!! Form::select('template_id', \App\Models\AttributeTemplate::pluck('name', 'id'), null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}

        <p class="help-block">{{ trans('crud.hints.attribute_template') }}</p>
    </div>
@endif