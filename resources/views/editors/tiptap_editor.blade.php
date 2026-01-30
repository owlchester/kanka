<div class="tiptap-editor entity-content" data-content="{{ ($source ?? $model ?? null)?->entry ?? '' }}">
    <tiptap
        @if (isset($campaign))
            @php
                $mentionUrlParams = [$campaign];
                if (isset($entity)) {
                    $mentionUrlParams['entity'] = $entity;
                }
            @endphp
        mentions="{{ route('search.mention', $mentionUrlParams) }}"
        gallery="{{ route('gallery.tiptap', [$campaign]) }}"
        @endif
    />
</div>
