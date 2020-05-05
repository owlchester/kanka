<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base;
?>
<div class="form-group">
    <label>{{ trans($trans . '.fields.type') }}</label>
    {!! Form::text(
        'type',
        (isset($isRandom) && $isRandom ? $random->generate('type') : FormCopy::field('type')->string()),
        [
            'placeholder' => trans($trans . '.placeholders.type'),
            'class' => 'form-control',
            'maxlength' => 45,
            'list' => 'entity-type-list-' . $trans,
            'autocomplete' => 'off'
        ]
    ) !!}
</div>
<div class="hidden">
    <datalist id="entity-type-list-<?=$trans?>">
        @foreach (\App\Facades\EntityCache::typeSuggestion($entityTypeListModel) as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </datalist>
</div>
