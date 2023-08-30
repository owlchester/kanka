<x-reorder.child id="story">
    {!! Form::hidden('posts[story]', 'story') !!}
    <div class="dragger pr-3">
        <span class="fa-solid fa-ellipsis-v" aria-hidden="true"></span>
    </div>
    <div class="name overflow-hidden flex-grow">
        <i class="fa-solid fa-align-justify" aria-hidden="true"></i> {{ __('crud.fields.entry') }}
    </div>
    <div class="self-end">
    </div>
</x-reorder.child>
