<?php /** @var \App\Models\TimelineEra[] $abilities */?>
<x-form :action="['entities.entity_abilities.reorder-save', $campaign, $entity]">
<div class="box-abilities-reorder w-max-4xl flex flex-col gap-5">
    @foreach($parents as $key => $parent)
        <div class="element-live-reorder flex flex-col gap-1">
            <div class="element bg-base-200 rounded flex flex-col gap-2 p-2">
                <div class="name overflow-hidden grow">
                    @if ($key === "")
                        {{ __('entities/abilities.reorder.parentless') }}
                    @else
                        {{ $parent[0]->ability->parent?->name }}
                    @endif
                </div>
                <div class="children sortable-elements flex flex-col gap-1">
                    @foreach($parent as $ability)
                        <x-reorder.child id="$ability->id">
                            <input type="hidden" name="ability[]" value="{{ $ability->id }}" />
                            <div class="dragger relative">
                                <x-icon class="fa-solid fa-sort" />
                            </div>
                            <div class="overflow-hidden grow flex flex-no-wrap items-center gap-2">
                                <span class="truncate">{!! $ability->ability->name !!}</span>
                                @if ($ability->ability->type)
                                <span class="text-xs text-neutral-content">
                                    ({!! $ability->ability->type!!})
                                </span>
                                @endif
                            </div>
                        </x-reorder.child>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <button class="btn2 btn-primary btn-block">
        {{ __('crud.save') }}
    </button>
</div>
</x-form>
