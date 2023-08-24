@inject('attributeTemplateService', 'App\Services\AttributeService')
@php $attributeTemplates = $attributeTemplateService->campaign($campaign)->templateList() @endphp
@if (empty($attributeTemplates))
    <?php return ?>
@endif

<div class="max-w-xl">
    <div class="field-template mb-5">
        <label for="template_id">
            {{ __('entities.attribute_template') }}
            <x-helpers.tooltip :title="__('crud.hints.attribute_template')" />
        </label>
        {!! Form::select('template_id', $attributeTemplates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'form-control', 'id' => 'template_id']) !!}

        <p class="help-block visible-xs visible-sm">{{ __('crud.hints.attribute_template') }}</p>
    </div>
</div>
