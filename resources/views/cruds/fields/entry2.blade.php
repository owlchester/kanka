<?php
$old = old('entry');
?>

<div class="md:col-span-2 form-group entry">
    <div class="flex gap-2 items-center">
        <label class="grow">
            {{ __('crud.fields.entry') }}
        </label>

        <a href="//docs.kanka.io/en/latest/features/mentions.html" class="pull-right btn2 btn-xs btn-link"
           target="_blank" title="{{ __('helpers.link.description') }}" data-toggle="tooltip">
            {{ __('crud.helpers.linking') }}
        </a>
    </div>

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
