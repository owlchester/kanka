<x-grid>
    @include('cruds.fields.name', ['trans' => 'attribute_templates'])

    @include('cruds.fields.parent_attribute_template', ['isParent' => true])

    <div class="entity-type">
        @include('components.form.entity_types', ['options' => [
            'model' => (isset($model) && $model->entityType ? $model->entityType : FormCopy::field('entityType')->related())
        ], 'label' => 'attribute_templates.fields.auto_apply'])
        <p class="help-block">{{ __('attribute_templates.hints.entity_type') }}</p>
    </div>
</x-grid>
