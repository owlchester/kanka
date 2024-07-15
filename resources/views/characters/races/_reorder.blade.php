<?php /** @var \App\Models\Race[] $races */?>

@if (!$races)
    <x-alert type="warning">
        <p>{{ __('crud.reorder.empty') }}</p>
    </x-alert>
    <?php return; ?>
@endif
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
                <div class="flex flex-wrap md:flex-no-wrap gap-2 md:gap-2 member-row items-center flex-grow">
                    <x-entities.thumbnail :entity="$race->race->entity" :title="$race->race->name" />
                    <x-entity-link
                        :entity="$race->race->entity"
                        :campaign="$campaign" />
                </div>
                <div class="grow-0 px-2 text-lg">
                    <input type="hidden" name="race_privates[{{ $race->race_id }}]" value="{{ $race->is_private }}" />
                    <i class="cursor-pointer hover:text-accent @if($race->is_private) fa-solid fa-lock-keyhole @else fa-regular fa-unlock-keyhole  @endif" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                </div>
            </x-reorder.child>
        @endforeach
    </div>
</div>

