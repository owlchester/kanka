<?php
$old = old('entry');
?>
<div class="field-entry md:col-span-2 entry flex flex-col gap-1">
    <div class="flex gap-2 items-center">
        <label class="grow m-0 text-xs font-medium opacity-80">
            {{ __('crud.fields.entry') }}
        </label>

        <a href="//docs.kanka.io/en/latest/features/mentions.html" class="btn2 btn-xs btn-link"
           target="_blank" data-title="{{ __('helpers.link.description') }}" data-toggle="tooltip">
            {{ __('crud.helpers.linking') }}
        </a>
    </div>

    @if (request()->has('tiptap'))
        @include('editors.tiptap_editor')
    @else
        <textarea id="entry" name="entry" class="w-full html-editor" rows="3">{!! FormCopy::field('entryForEdition')->string() ?: old('entry', $entity->entryForEdition ?? $model->entryForEdition ?? null) !!}</textarea>

    @endif
</div>
