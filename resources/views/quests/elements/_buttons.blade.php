@can('update', $model)
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#entity-main-block'])

        <a href="{{ route('quests.quest_elements.create', [$campaign, $model]) }}" class="btn2 btn-sm">
            <x-icon class="plus" />
            <span class="hidden lg:inline">{{ __('quests.show.actions.add_element') }}</span>
        </a>
    </div>
@endcan
