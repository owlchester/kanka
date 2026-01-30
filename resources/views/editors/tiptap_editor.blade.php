@php
    $fieldName = $fieldName ?? 'entry';
    $contentModel = $source ?? $model ?? null;
    $content = $contentModel?->{$fieldName} ?? '';
@endphp
<div class="tiptap-editor entity-content" data-content="{{ $content }}" data-field-name="{{ $fieldName }}">
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
