<?php /**
 * @var \App\Models\AttributeTemplate $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->attributeTemplate)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('attribute_templates.fields.attribute_template') }}" data-toggle="tooltip">
        <i class="fas fa-copy"></i>
        {!! $model->attributeTemplate->tooltipedLink() !!}
        </span>
    </div>
@endif
