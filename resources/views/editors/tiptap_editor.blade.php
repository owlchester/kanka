<div class="tiptap-editor entity-content">
    <tiptap
        mentions="{{ isset($campaign) ? route('search.mention', [$campaign, 'entity' => $entity ?? null]) : null }}"
        @if (isset($entity))
        api="{{ route('entities.api.document', [$campaign, $source ?? $entity]) }}"
        @endif
    />
</div>
