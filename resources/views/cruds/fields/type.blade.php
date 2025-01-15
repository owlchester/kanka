<x-forms.field
    field="type"
    label="{{ __('crud.fields.type') }}">
    <input type="text" name="type"
           placeholder="{{ __($trans . '.placeholders.type') }}" maxlength="45" list="entity-type-list-{{ $trans }}"
           spellcheck="true" autocomplete="off"
           value="{!! htmlspecialchars(str_replace('&amp;', '&', old('type', $source->entity->type ?? $entity->type ?? ''))) !!}"/>
    <div class="hidden">
        <datalist id="entity-type-list-<?=$trans?>">
            @foreach (\App\Facades\EntityCache::typeSuggestion($entityType ?? $entity->entityType) as $name)
                <option value="{{ $name }}">{!! $name !!}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
