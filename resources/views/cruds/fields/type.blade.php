<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base();
?>
<x-forms.field
    field="type"
    :label="__('crud.fields.type')">
    {!! Form::text(
        'type',
        FormCopy::field('type')->string(),
        [
            'placeholder' => trans($trans . '.placeholders.type'),
            'maxlength' => 45,
            'list' => 'entity-type-list-' . $trans,
            'autocomplete' => 'off',
            'spellcheck' => 'true'
        ]
    ) !!}
    <div class="hidden">
        <datalist id="entity-type-list-<?=$trans?>">
            @foreach (\App\Facades\EntityCache::typeSuggestion($entityTypeListModel) as $name)
                <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
