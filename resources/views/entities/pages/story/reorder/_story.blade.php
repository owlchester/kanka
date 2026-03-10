<x-reorder.child id="story" class="min-h-12">
    <input type="hidden" name="posts[story]" value="story" />
    <div class="dragger">
        <x-icon class="fa-regular fa-sort" />
    </div>
    <div class="overflow-hidden">
        <span class="truncate">{{ __('fields.description.label') }}</span>
    </div>
</x-reorder.child>
