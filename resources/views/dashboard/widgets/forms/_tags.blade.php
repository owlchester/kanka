<x-forms.field field="tags">
    <x-forms.tags
        :campaign="$campaign"
        :model="$model ?? null"
        allowClear="true"
        :dropdownParent="$dropdownParent ?? null"
    ></x-forms.tags>
    <p class="text-neutral-content md:hidden">
        {{ __('dashboard.widgets.recent.tags') }}
    </p>
    <input type="hidden" name="save_tags" value="1" />
</x-forms.field>
