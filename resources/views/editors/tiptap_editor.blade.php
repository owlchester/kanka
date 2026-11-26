@php
    $fieldName = $fieldName ?? 'entry';
    $fieldNameForEdition = $fieldName . 'ForEdition';
    $contentModel = $source ?? $model ?? null;
    $defaultContent = $contentModel?->{$fieldNameForEdition} ?? $contentModel?->{$fieldName} ?? '';
    $content = FormCopy::field($fieldNameForEdition)->string() ?: old($fieldName, $defaultContent);
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
        galleryUpload="{{ route('campaign.gallery.ajax-upload', $campaign) }}"
        @endif
    />
</div>
