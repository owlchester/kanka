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
$entities = \App\Models\Entity::unmentioned()
        ->inTags($widget->tags->pluck('id')->toArray())
        ->type($entityType)
        ->acl()
        ->with(['updater'])
        ->take(10)
        ->offset($offset)
        ->get();

$entityString = !empty($entityType) ? Str::plural($entityType) : null;
?>
<div class="panel panel-default" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            @if ($widget->conf('entity'))
                {{ __('entities.' . $entityString) }} -
            @endif{{ __('dashboard.widgets.unmentioned.title') }}

            @if (!empty($widget->tags))
                <span class="pull-right">
                    @foreach ($widget->tags as $tag)
                        {!! $tag->bubble() !!}
                    @endforeach
                </span>
            @endif
        </h3>
    </div>
    <div class="panel-body widget-recent-list">
        <?php /** @var \App\Models\Entity $entity */?>
        @foreach ($entities as $entity)
            <div class="flex">
                <a class="entity-image" style="background-image: url('{{ $entity->avatar(true) }}');"
                   title="{{ $entity->name }}"
                   href="{{ $entity->url() }}"></a>

                {!! $entity->tooltipedLink() !!}
                <div class="blame">
                    {{ !empty($entity->updated_by) ? \App\Facades\UserCache::name($entity->updated_by) : trans('crud.history.unknown') }}<br class="hidden-xs" />
                    @can('history', [$entity, $campaign])
                        @if (!empty($entity->updated_at))
                            <span class="elapsed" title="{{ $entity->updated_at }}">
                                {{ $entity->updated_at->diffForHumans() }}
                            </span>
                        @endif
                    @endcan
                </div>
            </div>
        @endforeach
        <div class="text-center">
            <a href="#" class="text-center widget-recent-more"
               data-url="{{ route('dashboard.unmentioned', ['id' => $widget->id, 'offset' => $offset + 10]) }}">
                {{ __('crud.actions.next') }}
            </a>
        </div>

    </div>
</div>
