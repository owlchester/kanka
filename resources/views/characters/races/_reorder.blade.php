<?php /** @var \App\Models\Race[] $races */?>
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('characters.races.helper', ['name' => $character->name]) !!}</p>
    </x-helper>

    @if (!$races)
        <x-alert type="warning">
            <p>{{ __('crud.reorder.empty') }}</p>
        </x-alert>
    @else
        <div class="w-full character-races-reorder flex flex-col gap-2">
            <div class="@if ($races->count() > 1) element-live-reorder sortable-elements @endif flex flex-col gap-2">
                @foreach($races as $race)
                    <x-reorder.child id="element-{{ $race->race_id }}">
                        <input type="hidden" name="character_race[]" value="{{ $race->race_id }}" />
                        @if ($races->count() > 1)
                            <div class="dragger">
                                <x-icon class="fa-solid fa-sort" />
                            </div>
                        @endif
                        <div class="flex flex-wrap md:flex-no-wrap gap-2 md:gap-2 member-row items-center grow">
                            <x-entities.thumbnail :entity="$race->race->entity" :title="$race->race->name" />
                            <x-entity-link
                                :entity="$race->race->entity"
                                :campaign="$campaign" />
                        </div>
                        <div class="grow-0 px-2 text-lg" x-data="{ isPrivate: {{ $race->is_private }} }">
                            <input type="hidden" name="race_privates[{{ $race->race_id }}]" :value="isPrivate ? 1 : 0" />
                            <i class="cursor-pointer hover:text-accent"
                               @click="isPrivate = !isPrivate"
                               :class="isPrivate ? 'fa-solid fa-lock-keyhole' : 'fa-regular fa-unlock-keyhole'"
                               :title="isPrivate ? '{{ __('entities/attributes.visibility.private') }}' : '{{ __('entities/attributes.visibility.public') }}'"></i>
                        </div>
                    </x-reorder.child>
                @endforeach
            </div>
        </div>
    @endif
</x-grid>



