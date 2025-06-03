<x-grid>
    @include('cruds.fields.name', ['trans' => 'attribute_templates'])

    @include('cruds.fields.parent_attribute_template', ['isParent' => true])

    <x-forms.field field="entity-type" :helper="__('attribute_templates.hints.entity_type')">
        @include('components.form.entity_types', ['options' => [
            'model' => (isset($model) && $model->entityType ? $model->entityType : FormCopy::field('entityType')->related())
        ], 'label' => 'attribute_templates.fields.auto_apply'])
    </x-forms.field>

    <x-forms.field field="enabled" :label=" __('attribute_templates.fields.is_enabled')">
        <input type="hidden" name="is_enabled" value="0" />
        <x-checkbox :text="__('attribute_templates.hints.is_enabled')">
            <input type="checkbox" name="is_enabled" value="1" @if (isset($model) && !$model->is_enabled) @else checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>


</x-grid>
