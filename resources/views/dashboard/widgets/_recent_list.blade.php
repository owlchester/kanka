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
       data-url="{{ route('dashboard.recent', ['id' => $widget->id, 'offset' => $offset + 10]) }}">
        {{ __('crud.actions.next') }}
    </a>
</div>
