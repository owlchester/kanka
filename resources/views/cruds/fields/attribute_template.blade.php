@inject('attributeTemplateService', 'App\Services\AttributeService')
@php $attributeTemplates = $attributeTemplateService->campaign($campaign)->templateList() @endphp
@if (empty($attributeTemplates))
    <?php return ?>
@endif

<div class="max-w-xl">
    <x-forms.field
        field="template"
        :label="__('entities.attribute_template')"
        :tooltip="true"
        :helper="__('crud.hints.attribute_template')">
        {!! Form::select('template_id', $attributeTemplates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'w-full', 'id' => 'template_id']) !!}
    </x-forms.field>
</div>
