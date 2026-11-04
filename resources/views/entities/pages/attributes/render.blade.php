@inject('templateService', 'App\Services\Attributes\TemplateService')
<?php
/**
 * @var \App\Services\Attributes\TemplateService $templateService
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$sheets = $entity->sheets;
$renderedSheets = 0;
?>

@foreach ($sheets as $sheet)
    @php
        $template = $sheet->source === 'legacy' ? $templateService->communityTemplate($sheet->reference) : null;
        $marketplaceTemplate = $sheet->source === 'marketplace' ? $templateService->campaign($campaign)->marketplaceTemplate($sheet->reference) : null;
    @endphp
    @if (!empty($template) && $entity->hasChild())
    @php $renderedSheets++; @endphp
    <x-box class="box-entity-attributes">
        @include($template->view(), ['model' => $model ?? $entity->child])
    </x-box>
    @elseif (!empty($marketplaceTemplate))
        @php $renderedSheets++; @endphp
        @include('entities.pages.attributes.rendering.marketplace', ['plugin' => $marketplaceTemplate])
    @endif
@endforeach
@if ($renderedSheets === 0)
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
