<?php
$old = old('entry');
?>

<div class="form-group">
    <label style="width: 100%">
        {{ __('crud.fields.entry') }}

        <a href="//docs.kanka.io/en/latest/features/mentions.html" class="pull-right btn btn-default btn-sm"
           target="_blank" title="{{ __('helpers.link.description') }}">
            <i class="fa-solid fa-question-circle"></i> {{ __('crud.helpers.linking') }}
        </a>
    </label>
    {!! Form::textarea(
        'entryForEdition',
        !empty($old) ? $old : FormCopy::field('entryForEdition')->string(),
        [
            'class' => 'form-control html-editor',
            'id' => 'entry',
            'name' => 'entry'
        ]
    ) !!}
</div>
