<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('attribute_templates.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('attribute_templates.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            {!! Form::select2(
                'attribute_template_id',
                (isset($model) && $model->attributeTemplate ? $model->attributeTemplate : $formService->prefillSelect('attributeTemplate', $source)),
                App\Models\AttributeTemplate::class,
                true,
                __('attribute_templates.fields.attribute_template'),
                null,
                __('attribute_templates.placeholders.attribute_template')
            ) !!}
            <p class="help-block">{{ __('attribute_templates.hints.parent_attribute_template') }}</p>
        </div>
        <div class="form-group">
            {!! Form::entityType(
                'entity_type_id',
                [
                    'model' => (isset($model) && $model->entityType ? $model->entityType : $formService->prefillSelect('entityType', $source)),
            ]) !!}
            <p class="help-block">{{ __('attribute_templates.hints.entity_type') }}</p>
        </div>

        @include('cruds.fields.private')
    </div>
</div>
