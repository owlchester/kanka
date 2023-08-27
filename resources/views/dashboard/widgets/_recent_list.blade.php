<?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
<div class="flex flex-col gap-2 mx-2">
@foreach ($entities as $entity)
    <div class="flex items-center gap-2">
        <a class="entity-picture inline-block rounded-full cover-background w-9 h-9 flex-shrink-0" style="background-image: url('{{ Avatar::entity($entity)->cached()->fallback()->size(40)->thumbnail() }}');"
            title="{{ $entity->name }}"
            href="{{ $entity->url() }}">
        </a>

        <div class="grow break-all">
            {!! $entity->tooltipedLink($entity->name, false) !!}

            @if ($entity->is_private)
                <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" aria-hidden="true"></i>
            @endif
        </div>

        <div class="blame flex-none text-right text-xs">
            <span class="author block">
                {{ !empty($entity->updated_by) ? \App\Facades\UserCache::name($entity->updated_by) : __('crud.history.unknown') }}
            </span>
@can('history', [$entity, $campaign])
            @if (!empty($entity->updated_at))
            <span class="elapsed text-neutral-content text-xs" title="{{ $entity->updated_at }} UTC">
                {{ $entity->updated_at->diffForHumans() }}
            </span>
            @endif
@endcan
        </div>
    </div>

@endforeach

@if($entities->hasMorePages())
<div class="text-center">
    <a href="#" class="widget-recent-more"
       data-url="{{ route('dashboard.recent', [$campaign, 'id' => $widget->id, 'page' => $entities->currentPage() + 1]) }}">
        <span class="inline-block p-3">{{ __('crud.actions.next') }}</span>
        <i class="fa-solid fa-spinner fa-spin spinner" style="display: none;" aria-hidden="true"></i>
    </a>
</div>
@endif
</div>
