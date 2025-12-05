<div class="dropdown">
    <div role="button" class="btn2" data-dropdown aria-expanded="false">
        <x-icon class="fa-regular fa-cog" />
        <span class="hidden lg:inline">
            {{ __('Configure') }}
        </span>
    </div>
    <div class="dropdown-menu hidden" role="menu">
        <div class="overflow-y-auto max-h-80">
            <x-dropdowns.item
                icon="fa-regular fa-shuffle"
                :link="route('bookmarks.reorder', [$campaign])">
                {{ __('bookmarks.reorder.title') }}
            </x-dropdowns.item>
            <x-dropdowns.item
                icon="fa-regular fa-bars-staggered"
                :link="route('campaign-sidebar', [$campaign])">
                {{ __('bookmarks.actions.customise') }}
            </x-dropdowns.item>
            <x-dropdowns.divider></x-dropdowns.divider>
            <x-dropdowns.item
                icon="fa-regular fa-book"
                link="https://docs.kanka.io/en/latest/advanced/bookmarks.html">
                {{ __('general.learn-more') }}
            </x-dropdowns.item>
        </div>
    </div>
</div>

