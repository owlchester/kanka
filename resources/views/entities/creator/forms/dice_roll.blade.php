    <div class="form-group">
        {!! Form::select2(
            'attribute_template_id',
            null,
            App\Models\AttributeTemplate::class,
            false,
            __('attribute_templates.fields.attribute_template'),
            null,
            __('attribute_templates.placeholders.attribute_template')
        ) !!}
        <p class="help-block">{{ __('attribute_templates.hints.parent_attribute_template') }}</p>
    </div>
