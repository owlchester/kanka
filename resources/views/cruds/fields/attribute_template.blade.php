@inject('attributeTemplateService', 'App\Services\AttributeService')
@php $attributeTemplates = $attributeTemplateService->campaign($campaign)->templateList() @endphp
@if (empty($attributeTemplates))
    <?php return ?>
@endif

<div class="max-w-xl">
    <x-forms.field
        field="template"
        :label="__('entities.attribute_template')"
        tooltip
        entityT
        :helper="__('crud.hints.kit')"
        :entityTypeID="config('entities.ids.attribute_template')">
        <x-forms.select name="template_id" :options="$attributeTemplates" id="template_id" placeholder="{{ __('entities/attributes.placeholders.template') }}" />
    </x-forms.field>
</div>
