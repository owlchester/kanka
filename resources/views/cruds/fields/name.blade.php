<?php
$required = !isset($bulk);
$fieldID = uniqid('name_');
?>
<x-forms.field
    field="name"
    :label="__('crud.fields.name')"
    :required="$required"
    :id="$fieldID">
    <input id="{{ $fieldID }}" type="text" name="name" placeholder="{{ __('entries/fields.name.placeholder') }}" maxlength="191"
           @if (isset($entityType)) data-live="{{ route('search-list', [$campaign, $entityType]) }}"
           data-duplicate=".duplicate-warning" data-1p-ignore="true"
           data-id="{{ $entity->id ?? null }}"
           @endif
           @if ($required) required="required" @endif
    value="{!! htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? ''))) !!}" />

    <div class="text-warning-content duplicate-warning flex flex-col gap-1 hidden">
        <span>{{ __('entities.creator.duplicate') }}</span>
        <div class="duplicates flex flex-wrap gap-2 items-center"></div>
    </div>
</x-forms.field>
