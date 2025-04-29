<x-reorder.child id="story">
    <input type="hidden" name="posts[story]" value="story" />
    <div class="dragger">
        <x-icon class="fa-regular fa-sort" />
    </div>
    <div class="overflow-hidden">
        <span class="truncate">{{ __('crud.fields.entry') }}</span>
    </div>
</x-reorder.child>
