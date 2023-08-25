@inject('moduleService', 'App\Services\Campaign\ModuleService')

<?php
use Illuminate\Support\Str;
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
if (!isset($offset)) {
    $offset = 0;
}
$entityType = $widget->conf('entity');
$entities = $widget->entities($offset);
if (($widget->conf('singular'))) {
    $entityString = !empty($entityType) ? (!$widget->conf('singular') ? $entityType : $moduleService->singular($entityType, 'entities.' . Str::plural($entityType))) : null;

} else {
    $entityString = !empty($entityType) ? ($widget->conf('singular') ? $entityType : $moduleService->plural($entityType, 'entities.' . Str::plural($entityType))) : null;
}
?>

<x-box padding="0" css="widget-list {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <h4 class="text-lg mb-3 px-4 pt-4">
        @if (!empty($widget->conf('text')))
            {{ $widget->conf('text') }}
        @else
            @if ($widget->conf('entity'))
                {{ __($entityString) }} -
            @endif{{ __('dashboard.widgets.recent.title') }}
        @endif

        @if (!empty($widget->tags))
            <span class="pull-right">
                    @foreach ($widget->tags as $tag)
                    {!! $tag->bubble() !!}
                @endforeach
                </span>
        @endif
    </h4>
    @if (!empty($widget->conf('singular')))
    <div class="widget-body widget-recent-body p-4">
        @include('dashboard.widgets._recent_singular', ['entities' => $entities])
    </div>
    @else
    <div class="panel-body widget-recent-list overflow-auto max-h-[400px]">
        @include('dashboard.widgets._recent_list', ['entities' => $entities, 'offset' => $offset])
    </div>
    @endif
</x-box>
