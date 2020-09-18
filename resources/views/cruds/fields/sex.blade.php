<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base;
?>
<div class="form-group">
    <label>{{ trans($trans . '.fields.sex') }}</label>
    {!! Form::text(
        'sex',
        (isset($isRandom) && $isRandom ? $random->generate('sex') : FormCopy::field('sex')->string()),
        [
            'placeholder' => trans($trans . '.placeholders.sex'),
            'class' => 'form-control',
            'maxlength' => 45,
            'list' => 'entity-gender-list-' . $trans,
            'autocomplete' => 'off'
        ]
    ) !!}
</div>
<div class="hidden">
    <datalist id="entity-gender-list-<?=$trans?>">
        @foreach (\App\Facades\CharacterCache::genderSuggestion() as $gender)
            <option value="{{ $gender }}">{{ $gender }}</option>
        @endforeach
    </datalist>
</div>
