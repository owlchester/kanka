<div class="post-tags flex gap-1 items-center flex-wrap" data-count="{{ count($tags) }}">
    @foreach ($tags as $tag)
        <x-tags.bubble :tag="$tag" :campaign="$campaign" />
    @endforeach
</div>
