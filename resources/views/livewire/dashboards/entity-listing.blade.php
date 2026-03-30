
<?php /** @var \App\Models\Entity[]|\Illuminate\Pagination\LengthAwarePaginator $entities */?>
<div class="flex flex-col gap-2">
@foreach ($entities as $entity)
    @if ($entity->entityType->isStandard() && empty($entity->entity_id))
        @continue
    @endif
    <div class="flex items-center gap-2 justify-between" data-entity-type="{{ $entity->entityType->pluralCode() }}">
        <div class="flex items-center gap-2 overflow-hidden">
            <a class="entity-picture inline-block rounded-full cover-background w-9 h-9 shrink-0" style="background-image: url('{{ Avatar::entity($entity)->fallback()->size(80)->thumbnail() }}');"
                title="{{ $entity->name }}"
                href="{{ $entity->url() }}">
            </a>

            <div class="break-all truncate">
                <x-entity-link
                    :entity="$entity"
                    :campaign="$campaign" />

                @if ($entity->status_id)
                    @php
                        $listingStatus = \Illuminate\Support\Facades\DB::table('category_statuses')->find($entity->status_id);
                    @endphp
                    @if ($listingStatus && $listingStatus->icon)
                        <x-icon class="fa-regular {{ $listingStatus->icon }}" tooltip :title="__('entities/statuses.' . $entity->entityType->code . '.' . $listingStatus->key)" />
                    @endif
                @endif
                @if ($entity->is_private)
                    <x-icon class="lock" tooltip title="{{ __('crud.is_private') }}" />
                @endif
            </div>
        </div>

        <div class="blame flex flex-col gap-0.5 text-xs items-end">
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
