<x-reorder.child id="story">
    <input type="hidden" name="posts[story]" value="story" />
    <div class="dragger pr-3">
        <span class="fa-solid fa-ellipsis-v" aria-hidden="true"></span>
    </div>
    <div class="name overflow-hidden grow">
        <i class="fa-solid fa-align-justify" aria-hidden="true"></i> {{ __('crud.fields.entry') }}
    </div>
    <div class="self-end">
    </div>
</x-reorder.child>
