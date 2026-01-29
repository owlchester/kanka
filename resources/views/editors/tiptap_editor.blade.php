<div class="tiptap-editor entity-content">
    <tiptap
        @if (isset($campaign))
        mentions="{{ route('search.mention', [$campaign, 'entity' => $entity ?? null]) }}"
        gallery="{{ route('gallery.tiptap', [$campaign]) }}"
        @if (isset($entity))
        api="{{ route('entities.api.document', [$campaign, $source ?? $entity]) }}"
        @endif
        @endif
    />
</div>
