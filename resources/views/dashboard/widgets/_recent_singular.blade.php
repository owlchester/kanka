<?php
if (empty($entities) || count($entities) == 0) {
    return;
}
/** @var \App\Models\Entity $entity */
$entity = $entities[0];
if (empty($entity->child)) {
    return;
}
?>
<div class="entity p-1">
    <div class="flex items-center gap-2 p-1">
        <a class="w-9 h-9 cover-background rounded-full inline-block" style="background-image: url('{{ $entity->avatarSize(40)->avatarV2() }}');"
            title="{{ $entity->name }}"
            href="{{ $entity->url() }}">

        </a>

        <div class="grow">
            {!! $entity->tooltipedLink($entity->name, false) !!}
        </div>

        <div class="flex-none text-right text-xs ">
            <span class="author block">
                {{ !empty($entity->updated_by) ? \App\Facades\UserCache::name($entity->updated_by) : __('crud.history.unknown') }}
            </span>
            @can('history', [$entity, $campaign])
                @if (!empty($entity->updated_at))
                    <span class="elapsed" title="{{ $entity->updated_at }} UTC">
                {{ $entity->updated_at->diffForHumans() }}
            </span>
                @endif
            @endcan
        </div>
    </div>

    <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
        <div class="entity-content">
            {!! $entity->child->entry() !!}
        </div>

        @include('dashboard.widgets.previews._members')
        @include('dashboard.widgets.previews._relations')
        @include('dashboard.widgets.previews._attributes')
    </div>
    <a href="#" class="preview-switch w-full inline-block text-center hidden"
       id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        <span class="sr-only">{{ __('Show more') }}</span>
    </a>
</div>
