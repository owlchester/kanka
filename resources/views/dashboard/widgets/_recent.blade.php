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
<div class="panel panel-default {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading px-4 py-2">
        <h3 class="panel-title m-0">
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
        </h3>
    </div>
    @if (!empty($widget->conf('singular')))
    <div class="panel-body p-4 widget-recent-body">
        @include('dashboard.widgets._recent_singular', ['entities' => $entities])
    @else
    <div class="panel-body p-4 widget-recent-list overflow-auto max-h-[400px]">
        @include('dashboard.widgets._recent_list', ['entities' => $entities, 'offset' => $offset])
    @endif
    </div>
</div>
