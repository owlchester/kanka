<a href="{{ route('entities.entity_abilities.reorder', [$campaign, $entity]) }}" class="btn2 btn-sm">
    <x-icon class="fa-regular fa-arrow-up-arrow-down" />
    <span class="hidden md:inline">{{ __('entities/abilities.show.reorder') }}</span>
    <span class="md:hidden">{{ __('sidebar.campaign_switcher.reorder') }}</span>
</a>
<a href="{{ route('entities.entity_abilities.reset', [$campaign, $entity]) }}" class="btn2 btn-sm" data-title="{{ __('entities/abilities.helpers.recharge') }}" data-toggle="tooltip">
    <x-icon class="fa-regular fa-redo" />
    <span class="hidden md:inline">{{ __('entities/abilities.actions.reset') }}</span>
    <span class="md:hidden">{{ __('crud.actions.reset') }}</span>
</a>
@if ($entity->isCharacter())
    @php $raceModule = \App\Models\EntityType::default()->where('code', 'race')->first(); @endphp
    <a href="{{ route('entities.entity_abilities.import.confirm', [$campaign, $entity]) }}" class="btn2 btn-sm"
        data-toggle="dialog" data-target="abilities-dialog" data-url="{{ route('entities.entity_abilities.import.confirm', [$campaign, $entity]) }}" data-title="{{ __('entities/abilities.helpers.sync') }}" data-toggle="tooltip">
        <x-icon :class="$raceModule->icon()" />
        <span class="hidden md:inline">{{ __('entities/abilities.actions.sync') }}</span>
        <span class="md:hidden">{{ __('crud.add') }}</span>
    </a>

@endif
<a href="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}" class="btn2 btn-sm"
    data-toggle="dialog" data-target="abilities-dialog" data-url="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}">
    <x-icon class="plus" />
    <span class="hidden md:inline">{{ __('entities/abilities.actions.add') }}</span>
    <span class="md:hidden">{{ __('crud.add') }}</span>
</a>
