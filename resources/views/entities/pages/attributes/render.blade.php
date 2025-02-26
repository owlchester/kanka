@inject('attributeService', 'App\Services\AttributeService')
@inject('templateService', 'App\Services\Attributes\TemplateService')
<?php
/**
 * @var \App\Services\AttributeService $attributeService
 * @var \App\Services\Attributes\TemplateService $templateService
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$layout = $entity->entityAttributes->where('name', '_layout')->first();

if (!empty($layout)) {
    $template = $template ?? $templateService->communityTemplate($layout->value);
    $marketplaceTemplate = $marketplaceTemplate ?? $templateService->campaign($campaign)->marketplaceTemplate($layout->value);
}
?>

@if (!empty($template) && $entity->hasChild())
    <x-box css="box-entity-attributes">
        @include($template->view(), ['model' => $model ?? $entity->child])
    </x-box>
@elseif (!empty($marketplaceTemplate))
    @include('entities.pages.attributes.rendering.marketplace', ['plugin' => $marketplaceTemplate])
@else
    @include('entities.pages.attributes.rendering.default', [
        'attributes' => $entity->attributes()->with('entity')->ordered()->get()
    ])
@endif

@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="live-attribute-dialog" :loading="true"></x-dialog>
@endsection
