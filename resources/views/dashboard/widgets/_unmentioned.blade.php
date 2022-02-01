<?php
use Illuminate\Support\Str;
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
$entityType = $widget->conf('entity');
$entities = $widget->entities();

$entityString = !empty($entityType) ? Str::plural($entityType) : null;
?>
<div class="panel panel-default {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            @if (!empty($widget->conf('text')))
                {{ $widget->conf('text') }}
            @else
                @if ($widget->conf('entity'))
                    {{ __('entities.' . $entityString) }} -
                @endif{{ __('dashboard.widgets.unmentioned.title') }}
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
    <div class="panel-body widget-recent-list">
        <?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
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
        @if($entities->hasMorePages())
        <div class="text-center">
            <a href="#" class="text-center widget-recent-more"
               data-url="{{ route('dashboard.unmentioned', ['id' => $widget->id, 'page' => $entities->currentPage() + 1]) }}">
                {{ __('crud.actions.next') }}
            </a>
        </div>
        @endif

    </div>
</div>
