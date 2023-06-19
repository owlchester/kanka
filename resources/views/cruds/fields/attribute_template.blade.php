@inject('attributeTemplateService', 'App\Services\AttributeService')
@php $attributeTemplates = $attributeTemplateService->campaign($campaignService->campaign())->templateList() @endphp
@if (empty($attributeTemplates))
    <?php return ?>
@endif

<div class="max-w-xl">
    <div class="field-template mb-5">
        <label for="template_id">
            {{ __('entities.attribute_template') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" title="{{ __('crud.hints.attribute_template') }}"></i>
        </label>
        {!! Form::select('template_id', $attributeTemplates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'form-control', 'id' => 'template_id']) !!}

        <p class="help-block visible-xs visible-sm">{{ __('crud.hints.attribute_template') }}</p>
    </div>
</div>
