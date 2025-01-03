<div>

<?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
<div class="flex flex-col gap-2">

@foreach ($entities as $entity)
    <div class="flex items-center gap-2">
        <a class="entity-picture inline-block rounded-full cover-background w-9 h-9 flex-shrink-0" style="background-image: url('{{ Avatar::entity($entity)->fallback()->size(40)->thumbnail() }}');"
            title="{{ $entity->name }}"
            href="{{ $entity->url() }}">
        </a>

        <div class="grow break-all truncate">
            <x-entity-link
                :entity="$entity"
                :campaign="$campaign" />

            @if ($entity->is_private)
                <x-icon class="lock" tooltip title="{{ __('crud.is_private') }}" />
            @endif
        </div>

        <div class="blame flex-none text-right text-xs">
            <span class="author block">
                @if (empty($entity->updated_by) && !empty($entity->created_by))
                    {{ \App\Facades\UserCache::name($entity->created_by) }}
                @elseif (!empty($entity->updated_by))
                    {{ \App\Facades\UserCache::name($entity->updated_by) }}
                @else
                    {{ __('crud.history.unknown') }}
                @endif
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

@if($hasMorePages)
    <div class="text-center">
        <a
            class="cursor-pointer"
            wire:click="loadEntities"
        >
            {{ __('entities/story.actions.load_more') }}
        </a>
    </div>
@endif

</div>

</div>
