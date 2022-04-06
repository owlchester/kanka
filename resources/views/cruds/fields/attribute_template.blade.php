@inject('attributeTemplateService', 'App\Services\AttributeService')
@php $attributeTemplates = $attributeTemplateService->campaign($campaign->campaign())->templateList() @endphp
@if (empty($attributeTemplates))
    <?php return ?>
@endif

<div class="row">
    <div class="col-lg-4 col-sm-6">
        <div class="form-group">
            <label>
                {{ __('crud.fields.attribute_template') }}
                <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('crud.hints.attribute_template') }}"></i>
            </label>
            {!! Form::select('template_id', $attributeTemplates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}

            <p class="help-block visible-xs visible-sm">{{ __('crud.hints.attribute_template') }}</p>
        </div>
    </div>
</div>
