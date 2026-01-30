<?php
$old = old('entry');
?>
<div class="field-entry md:col-span-2 entry flex flex-col gap-1">
    <div class="flex gap-2 items-center">
        <label class="grow m-0 text-xs font-medium opacity-80">
            {{ __('crud.fields.entry') }}
        </label>

        <a
            href="//docs.kanka.io/en/latest/features/mentions.html"
            class="btn2 btn-xs btn-link"
            data-title="{{ __('helpers.link.description') }}"
            data-toggle="tooltip">
            {{ __('crud.helpers.linking') }}
        </a>
    </div>

    @include('cruds.fields.entry', ['model' => $entity])
</div>
