<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
if (!isset($offset)) {
    $offset = 0;
}

$entity = $widget->randomEntity();

if (empty($entity) || empty($entity->child)) {
    return;
}
\App\Facades\Dashboard::add($entity);
$model = $entity->child;

$specificPreview = 'dashboard.widgets.previews.' . $entity->type();
$customName = !empty($widget->conf('text')) ? str_replace('{name}', $model->name, $widget->conf('text')) : null;
$widget->setEntity($entity);
?>
<x-box padding="0" css="widget-calendar widget-list {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $entity, 'customName' => $customName])
@else
    <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity" />
    <div class="panel-body p-4">
        @if ($widget->conf('full') === '1')
            <div class="entity-content">
                {!! $model->entry() !!}
            </div>

            @include('dashboard.widgets.previews._members')
            @include('dashboard.widgets.previews._relations')
            @include('dashboard.widgets.previews._attributes')
        @else
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
            <div class="entity-content">
                {!! $model->entry() !!}
            </div>

            @include('dashboard.widgets.previews._members')
            @include('dashboard.widgets.previews._relations')
            @include('dashboard.widgets.previews._attributes')
        </div>
        <a href="#" class="preview-switch w-full inline-block text-center hidden hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
            <span class="sr-only">{{ __('Show more') }}</span>
        </a>
        @endif
    </div>
@endif
</x-box>
