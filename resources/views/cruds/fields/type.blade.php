<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base;
?>
<div class="field-type">
    @if (!isset($floating))<label>{{ __('crud.fields.type') }}</label>@endif
    {!! Form::text(
        'type',
        FormCopy::field('type')->string(),
        [
            'placeholder' => trans($trans . '.placeholders.type'),
            'class' => 'form-control',
            'maxlength' => 45,
            'list' => 'entity-type-list-' . $trans,
            'autocomplete' => 'off',
            'spellcheck' => 'true'
        ]
    ) !!}
    @if (isset($floating))<label>{{ __($trans . '.fields.type') }}</label>@endif
</div>
<div class="hidden">
    <datalist id="entity-type-list-<?=$trans?>">
        @foreach (\App\Facades\EntityCache::typeSuggestion($entityTypeListModel) as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </datalist>
</div>
