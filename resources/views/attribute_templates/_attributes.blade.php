@inject('attributeService', 'App\Services\AttributeService')
<?php
/**
 * @var \App\Services\AttributeService $attributeService
 * @var \App\Models\AttributeTemplate $model
 */
$layout = $model->entity->attributes()->where(['name' => '_layout'])->first();
if ($layout) {
    $template = $attributeService->communityTemplate($layout->value);
    $marketplaceTemplate = $attributeService->marketplaceTemplate($layout->value, $campaignService->campaign());
}
?>

@if (!empty($template))
    @include($template->view())
@elseif (!empty($marketplaceTemplate))
    @include('cruds.attributes.marketplace_template', ['plugin' => $marketplaceTemplate])
@else
    @include('cruds.partials.attributes', [
        'attributes' => $model->entity->attributes()->with('entity')->ordered()->get()
    ])
@endif
