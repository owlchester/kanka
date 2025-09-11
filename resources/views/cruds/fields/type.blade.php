@php
    $fieldID = uniqid('type_');
@endphp
<x-forms.field
    field="type"
    label="{{ __('crud.fields.type') }}"
    :id="$fieldID">

    <input id="{{ $fieldID }}" type="text" name="type"
           placeholder="{{ __($trans . '.placeholders.type') }}" maxlength="45" list="entity-type-list-{{ $trans }}"
           spellcheck="true" autocomplete="off"
           value="{!! htmlspecialchars(str_replace('&amp;', '&', old('type', $source->type ?? $entity->type ?? ''))) !!}"/>
    <div class="hidden">
        <datalist id="entity-type-list-<?=$trans?>">
            @foreach (\App\Facades\EntityCache::campaign($campaign)->typeSuggestion($entityType ?? $entity->entityType) as $name)
                <option value="{{ $name }}">{!! $name !!}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
