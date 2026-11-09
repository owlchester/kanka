<x-grid>
    @include('cruds.fields.parent')

    <x-forms.field field="entity-type" :label="__('attribute_templates.fields.auto_apply')" id="entity_type_id" :helper="__('attribute_templates.hints.entity_type')">
        @include('components.form.entity_types', ['options' => [
            'model' => (isset($model) && $model->entityType ? $model->entityType : FormCopy::field('entityType')->related())
        ]])
    </x-forms.field>

    <x-forms.field field="enabled" :label=" __('attribute_templates.fields.is_enabled')">
        <input type="hidden" name="is_enabled" value="0" />
        <x-checkbox :text="__('attribute_templates.hints.is_enabled')">
            <input type="checkbox" name="is_enabled" value="1" @if (isset($model) && !$model->is_enabled) @else checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>


</x-grid>
