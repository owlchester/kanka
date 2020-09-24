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
$entities = \App\Models\Entity::recentlyModified()
        ->inTags($widget->tags->pluck('id')->toArray())
        ->type($entityType)
        ->acl()
        ->with(['tags', 'updater'])
        ->take(10)
        ->offset($offset)
        ->get();

$entityString = !empty($entityType) ? ($widget->conf('singular') ? $entityType : Str::plural($entityType)) : null;
?>
<div class="panel panel-default" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            @if ($widget->conf('entity'))
                {{ __('entities.' . $entityString) }} -
            @endif{{ __('dashboard.widgets.recent.title') }}

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
    <div class="panel-body widget-recent-body">
        @include('dashboard.widgets._recent_singular', ['entities' => $entities])
    @else
    <div class="panel-body widget-recent-list">
        @include('dashboard.widgets._recent_list', ['entities' => $entities, 'offset' => $offset])
    @endif
    </div>
</div>
