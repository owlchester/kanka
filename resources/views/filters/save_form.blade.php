<x-form :action="['save-filters', $campaign, $entityType, 'm' => $mode]" method="GET" id="crud-filters-form"
        class="block">
    <x-dialog.header>
        {{ __('filters.actions.bookmark') }}
    </x-dialog.header>
    <x-dialog.article>
        <x-helper>
            <p>{{ __('filters.bookmark.helper') }}</p>
        </x-helper>
        <x-grid type="1/1">
            <x-forms.field
                    field="name"
                    :label="__('crud.fields.name')">
                <input type="text" name="name"
                       value="{{  __('filters.bookmark.name', ['module' => $entityType->plural()]) }}" maxlength="191"
                       class="w-full" autocomplete="off"/>
            </x-forms.field>

            @if ($campaign->boosted())
                <x-forms.field
                        field="icon"
                        :label="__('maps/markers.fields.icon')"
                        :helper="__('filters.helpers.icon', [
            'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\'>FontAwesome</a>',
            'example' => '<i class=\'fa-regular fa-user-beard-bolt\' aria-hidden=\'true\'></i> <code>fa-solid fa-horse</code>',
            ])">
                    <input type="text" name="icon" value="fa-solid fa-th-list" maxlength="191" class="w-full"
                           autocomplete="off"/>
                </x-forms.field>
            @else
                <x-forms.field
                        field="icon"
                        :label="__('entities/links.fields.icon')">
                    <x-slot name="helper">
                        {!! __('filters.helpers.icon-premium', [
                            'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\'>FontAwesome</a>',
                            'example' => '<i class=\'fa-regular fa-user-beard-bolt\' aria-hidden=\'true\'></i> <code>fa-solid fa-horse</code>',
                            'premium' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaign') . '</a>',
                        ]) !!}
                    </x-slot>
                </x-forms.field>
                <input type="hidden" name="icon" value="fa-solid fa-th-list"/>
            @endif


            <x-forms.field
                    field="position"
                    :label="__('bookmarks.fields.position')"
                    tooltip
                    :helper="__('entities/links.helpers.parent')">
                <x-forms.select name="parent" :options="$parents"
                                :selected="$entityType->plural() ?? 'bookmarks'"/>
                <p class="text-neutral-content md:hidden">
                    {!! __('entities/links.helpers.parent') !!}
                </p>
            </x-forms.field>
        </x-grid>
        <br class="clear-both"/>
    </x-dialog.article>
    @if (auth()->check())
        <footer class="flex flex-wrap gap-3 justify-between items-start p-3">
            <menu class="flex flex-wrap gap-3 ps-0">
                <button type="submit" class="btn2 btn-primary btn-sm">
                    <x-icon class="fa-solid fa-filter"/>
                    {{ __('crud.save') }}
                </button>
            </menu>
        </footer>
    @endif
</x-form>
