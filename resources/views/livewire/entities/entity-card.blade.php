@php
    /** @var \App\Models\Entity $entity */
    $stacked = min(2, $entity->children_count);
    $dataAttributes = [];
    if ($entity->is_private) {
        $dataAttributes[] = 'private';
    }
@endphp
@if ($stacked > 0)
    <div class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48 " data-stack="{{ $stacked }}">
        <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md aspect-square w-full flex flex-col bg-box" title="{{ $entity->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $entity->id }}" data-entity-type="{{ $entity->entityType->code }}" @if (!empty($entity->type)) data-type="{{ \Illuminate\Support\Str::slug($entity->type) }}" @endif>
            <div role="button" wire:click="open()"  class="block avatar grow relative cover-background overflow-hidden text-center" style="background-image: url('{{ Avatar::entity($entity)->fallback()->size(192, 144)->thumbnail() }}')">

                @if ($entity->is_private)
                    <div class="bubble-private absolute left-1.5 top-1.5 text-base shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content">
                        <x-icon class="fa-regular fa-lock" :title="__('crud.is_private')" />
                    </div>
                @endif
            </div>
            <a href="{{ $entity->url('show', [], $campaign) }}" class="block text-center relative truncate h-12 p-4" data-toggle="tooltip-ajax" data-id="{{ $entity->id }}"
               data-url="{{ route('entities.tooltip', [$campaign, $entity->id]) }}">
                {!! $entity->name !!} I HAVE KIDS
            </a>
        </div>
        @for ($s = 0; $s < $stacked; $s++)
            <div class="entity entity-stack bg-base-300 w-full overflow-hidden rounded aspect-square flex flex-col shadow-sm" title="{{ __('datagrids.tooltips.nested') }}" data-stack="{{ $s }}">
                <div class="block grow"></div>
                <div class="block h-12 p-4 bg-box"></div>
            </div>
        @endfor
    </div>
@else
    <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box @if (isset($isParent)) shadow-lg stacking-parent font-bold @endif" title="{{ $entity->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $entity->id }}" data-entity-type="{{ $entity->entityType->code }}" @if (!empty($entity->type)) data-type="{{ \Illuminate\Support\Str::slug($entity->type) }}" @endif>
        <a href="{{ $entity->url('show', [], $campaign) }}" class="block avatar grow relative cover-background" style="background-image: url('{{ Avatar::entity($entity)->fallback()->size(192, 144)->thumbnail() }}')">
            @if ($entity->is_private)
                <div class="bubble-private absolute left-1.5 top-1.5 shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 text-base bg-box opacity-80 text-base-content">
                    <x-icon class="fa-regular fa-lock" :title="__('crud.is_private')" />
                </div>
            @endif
        </a>
        <a href="{{ $entity->url('show', [], $campaign) }} }}" class="block truncate text-center px-2 py-4 h-12" data-toggle="tooltip-ajax" data-id="{{ $entity->id }}"
           data-url="{{ route('entities.tooltip', [$campaign, $entity->id]) }}">
            {!! $entity->name !!}
        </a>
    </div>
@endif
