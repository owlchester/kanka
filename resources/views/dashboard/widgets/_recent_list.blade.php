<?php /** @var \App\Models\Entity $entity */?>
@foreach ($entities as $entity)
    @if (empty($entity->child))
        @continue
    @endif
    <div class="flex">
            <a class="entity-image" style="background-image: url('{{ $entity->avatar(true) }}');"
               title="{{ $entity->name }}"
               href="{{ $entity->url() }}"></a>

            {!! $entity->tooltipedLink() !!}
        <div class="blame">
            {{ $entity->updater ? $entity->updater->name : trans('crud.history.unknown') }}<br class="hidden-xs" />
            <span class="elapsed" title="{{ $entity->updated_at }}">
                {{ $entity->updated_at->diffForHumans() }}
            </span>
        </div>
    </div>

@endforeach
<div class="text-center">
    <a href="#" class="text-center widget-recent-more"
       data-url="{{ route('dashboard.recent', ['id' => $widget->id, 'offset' => $offset + 10]) }}">
        {{ __('crud.actions.next') }}
    </a>
</div>
