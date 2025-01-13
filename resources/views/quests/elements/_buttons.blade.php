<div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
    @can('update', $model)
        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#entity-main-block'])

        <a href="{{ route('quests.quest_elements.create', [$campaign, $model]) }}" class="btn2 btn-sm">
            <x-icon class="plus" />
            <span class="hidden lg:inline">{{ __('quests.show.actions.add_element') }}</span>
        </a>
    @endcan
    @include('entities.headers.actions', ['edit' => false])
</div>
