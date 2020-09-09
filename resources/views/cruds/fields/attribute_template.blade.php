@if(\App\Models\AttributeTemplate::count() > 0)
    <div class="form-group">
        <label>{{ trans('crud.fields.attribute_template') }}</label>
        {!! Form::select('template_id', \App\Models\AttributeTemplate::orderBy('name', 'ASC')->pluck('name', 'id'), null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}

        <p class="help-block">{{ trans('crud.hints.attribute_template') }}</p>
    </div>
@endif
