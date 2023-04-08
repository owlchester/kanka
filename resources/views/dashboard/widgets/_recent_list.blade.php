<?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
@foreach ($entities as $entity)
    <div class="flex items-center align-items-center gap-2 p-1 hover:bg-gray-400/10">
        <a class="inline-block rounded-full cover-background w-9 h-9" style="background-image: url('{{ $entity->avatarSize(36)->avatarV2() }}');"
            title="{{ $entity->name }}"
            href="{{ $entity->url() }}">
        </a>

        <div class="grow">
            {!! $entity->tooltipedLink($entity->name, false) !!}

            @if ($entity->is_private)
                <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
            @endif
        </div>

        <div class="blame flex-0 text-right text-xs">
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
