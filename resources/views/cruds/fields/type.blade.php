<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base();
?>
<x-forms.field
    field="type"
    label="{{ __('crud.fields.type') }}">
    <input type="text" name="type" value="{{ htmlspecialchars(old('type', $source->type ?? $model->type ?? null)) }}"
           placeholder="{{ __($trans . '.placeholders.type') }}" maxlength="45" list="entity-type-list-{{ $trans }}"
           spellcheck="true" autocomplete="off" />
    <div class="hidden">
        <datalist id="entity-type-list-<?=$trans?>">
            @foreach (\App\Facades\EntityCache::typeSuggestion($entityTypeListModel) as $name)
                <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
