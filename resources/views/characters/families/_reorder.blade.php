<?php /** @var \App\Models\CharacterFamily[] $families */?>

@if (!$families)
    <x-alert type="warning">
        <p>{{ __('crud.reorder.empty') }}</p>
    </x-alert>
    <?php return; ?>
@endif
<div class="w-full character-families-reorder flex flex-col gap-2">
    <div class="@if ($families->count() > 1) element-live-reorder sortable-elements @endif flex flex-col gap-2">
        @foreach($families as $family)
            <x-reorder.child id="element-{{ $family->family_id }}">
                <input type="hidden" name="character_family[]" value="{{ $family->family_id }}" />
                @if ($families->count() > 1)
                <div class="dragger">
                    <x-icon class="fa-solid fa-sort" />
                </div>
               @endif
                <div class="flex flex-wrap md:flex-no-wrap gap-2 md:gap-2 member-row items-center flex-grow">
                    <x-entities.thumbnail :entity="$family->family->entity" :title="$family->family->name" />
                    <x-entity-link
                        :entity="$family->family->entity"
                        :campaign="$campaign" />
                </div>
                <div class="grow-0 px-2 text-lg">
                    <input type="hidden" name="family_privates[{{ $family->family_id }}]" value="{{ $family->is_private }}" />
                    <i class="cursor-pointer hover:text-accent @if($family->is_private) fa-solid fa-lock-keyhole @else fa-regular fa-unlock-keyhole  @endif" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"></i>
                </div>
            </x-reorder.child>
        @endforeach
    </div>
</div>

