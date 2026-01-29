<div class="tiptap-editor entity-content">
    <tiptap
        mentions="{{ isset($campaign) ? route('search.live', [$campaign, 'v2' => 'true', 'new' => true]) : null }}"
        api="{{ route('entities.api.document', [$campaign, $source ?? $entity]) }}"
    />
</div>
