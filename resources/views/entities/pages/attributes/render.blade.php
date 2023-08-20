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

if ($layout && !empty($campaign)) {
    $template = $template ?? $templateService->communityTemplate($layout->value);
    $marketplaceTemplate = $marketplaceTemplate ?? $templateService->marketplaceTemplate($layout->value, $campaign);
}
?>

@if (!empty($template))
    <x-box css="box-entity-attributes">
        @include($template->view())
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
    <div class="modal fade" id="live-attribute-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100"></div>
        </div>
    </div>
@endsection
