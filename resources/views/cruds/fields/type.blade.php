<?php
/** @var \App\Models\MiscModel $entityTypeListModel */
$entityTypeListModel = new $base;
?>
<div class="form-group">
    <label>{{ trans($trans . '.fields.type') }}</label>
    {!! Form::text(
        'type',
        (isset($isRandom) && $isRandom ? $random->generate('type') : $formService->prefill('type', $source)),
        [
            'placeholder' => trans($trans . '.placeholders.type'),
            'class' => 'form-control',
            'maxlength' => 191,
            'list' => 'entity-type-list',
            'autocomplete' => 'off'
        ]
    ) !!}
</div>
<div class="hidden">
    <datalist id="entity-type-list">
        @foreach ($entityTypeListModel->entityTypeList() as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </datalist>
</div>
