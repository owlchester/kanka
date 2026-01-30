<div class="tiptap-editor entity-content" data-content="{{ ($source ?? $entity ?? null)?->entry ?? '' }}">
    <tiptap
        @if (isset($campaign))
        mentions="{{ route('search.mention', [$campaign, 'entity' => $entity ?? null]) }}"
        gallery="{{ route('gallery.tiptap', [$campaign]) }}"
        @if (isset($entity) && $entity instanceof \App\Models\Entity)
        mentions-api="{{ route('entities.api.document', [$campaign, $source ?? $entity]) }}"
        @endif
        @endif
    />
</div>
