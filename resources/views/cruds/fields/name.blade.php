<?php
$required = !isset($bulk);
?>

<x-forms.field
    field="name"
    :label="__('crud.fields.name')"
    :required="$required">
    <input type="text" name="name" placeholder="{{ __('crud.placeholders.name') }}" maxlength="191" data-live="{{ route('search.live', $campaign) }}"
           data-type="{{ \Illuminate\Support\Str::singular($trans) }}" data-duplicate=".duplicate-warning" data-1p-ignore="true"
           data-id="{{ $model->entity->id ?? null }}"
           @if ($required) required="required" @endif
    value="{!! htmlspecialchars(old('name', $model->name ?? '')) !!}" />

    <div class="text-warning-content duplicate-warning flex flex-col gap-1 hidden">
        <span>{{ __('entities.creator.duplicate') }}</span>
        <div class="duplicates flex flex-wrap gap-2 items-center"></div>
    </div>
</x-forms.field>
