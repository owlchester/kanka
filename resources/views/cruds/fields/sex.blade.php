<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base;
?>
<div class="form-group">
    <label>{{ __($trans . '.fields.sex') }}</label>
    {!! Form::text(
        'sex',
        FormCopy::field('sex')->string(),
        [
            'placeholder' => __($trans . '.placeholders.sex'),
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
