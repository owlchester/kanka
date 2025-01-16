@inject('moduleService', 'App\Services\Campaign\ModuleService')

<?php
use Illuminate\Support\Str;
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
$entityType = $widget->conf('entity');
$entities = $widget->entities();
if (($widget->conf('singular'))) {
    $entityString = !empty($entityType) ? (!$widget->conf('singular') ? $entityType : $moduleService->singular($entityType, 'entities.' . Str::plural($entityType))) : null;

    if ($entities->count() > 0) {
        $entity = $entities[0];
        if (!$entity->isMissingChild()) {
            ?>
            @include('dashboard.widgets._preview', [
    'entity' => $entity,
])
            <?php
            return;
        }
    }
} else {
    $entityString = !empty($entityType) ? ($widget->conf('singular') ? $entityType : $moduleService->plural($entityType, 'entities.' . Str::plural($entityType))) : null;
}
?>
<x-box padding="0" css="widget-list {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <h4 class="text-lg mb-3 px-4 pt-4 flex gap-2">
        <span class="grow">
            <x-widgets.filteredLink :campaign="$campaign" :widget="$widget" :entityString="$entityString" />
        </span>

        @if (!empty($widget->tags))
            <span class="flex-none flex gap-1">
                @foreach ($widget->tags as $tag)
                    <x-tags.bubble :tag="$tag" />
                @endforeach
            </span>
        @endif
    </h4>
    @if (!empty($widget->conf('singular')))
    <div class="widget-body widget-recent-body p-4">
        <p class="italic">{{ __('search.lookup.empty') }}</p>
    </div>
    @else
    <div class="widget-recent-list overflow-auto px-4 pb-4 max-h-[400px]">
        @include('dashboard.widgets._recent_list')
    </div>
    @endif
</x-box>
