<?php
$old = old('entry');
?>

<div class="md:col-span-2 form-group entry">
    <label style="width: 100%">
        {{ __('crud.fields.entry') }}

        <a href="//docs.kanka.io/en/latest/features/mentions.html" class="pull-right btn2 btn-sm"
           target="_blank" title="{{ __('helpers.link.description') }}">
            <x-icon class="question"></x-icon> {{ __('crud.helpers.linking') }}
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
