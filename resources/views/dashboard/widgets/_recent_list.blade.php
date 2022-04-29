<?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
@foreach ($entities as $entity)
    <div class="flex">
        <a class="entity-image" style="background-image: url('{{ ($campaign->boosted(true) && !empty($entity->image_uuid) && !empty($entity->image) ? Img::crop(40, 40)->url($entity->image->path) : $entity->avatar(true)) }}');"
           title="{{ $entity->name }}"
           href="{{ $entity->url() }}">

        </a>

        {!! $entity->tooltipedLink() !!}

        @if ($entity->is_private)
            <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
        @endif

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
       data-url="{{ route('dashboard.recent', ['id' => $widget->id, 'page' => $entities->currentPage() + 1]) }}">
        <span>{{ __('crud.actions.next') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" style="display: none;"></i>
    </a>
</div>
@endif
