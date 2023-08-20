@can('update', $model)
    <div class="header-buttons flex gap-2 items-center justify-end">

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#entity-main-block'])

        <a href="{{ route('quests.quest_elements.create', [$campaign, $model]) }}" class="btn2 btn-sm btn-accent">
            <x-icon class="plus"></x-icon>
            <span class="hidden-xs hidden-sm">{{ __('quests.show.actions.add_element') }}</span>
        </a>
    </div>
@endcan
