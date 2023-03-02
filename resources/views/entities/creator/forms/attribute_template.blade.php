<div class="form-group">
    {!! Form::select2(
        'attribute_template_id',
        (isset($model) && $model->attributeTemplate ? $model->attributeTemplate : FormCopy::field('attributeTemplate')->select()),
        App\Models\AttributeTemplate::class,
        false,
        __('attribute_templates.fields.attribute_template'),
        null,
        __('attribute_templates.placeholders.attribute_template'),
        null,
        request()->ajax() ? '#entity-modal' : null,
    ) !!}
</div>
